from google_play_scraper import app, reviews_all
import pandas as pd
from sqlalchemy import create_engine, text
import pymysql
from vaderSentiment.vaderSentiment import SentimentIntensityAnalyzer
import re
import string
import sys

user_input = int(sys.argv[1])

# Database connection
db_user = "root"
db_password = ""
db_host = "localhost"
db_name = "klasifikasi-naive-bayes"

connection_string = f"mysql+pymysql://{db_user}:{db_password}@{db_host}/{db_name}"
db_engine = create_engine(connection_string)

# ID aplikasi di Google Play Store
if user_input == 1:
    app_id = "com.gojek.app"
elif user_input == 2:
    app_id = "com.grabtaxi.passenger"
else:
    app_id = "sinet.startup.inDriver"

print("Mengambil data aplikasi...")
# Mengambil data aplikasi
app_data = app(app_id)
print("Data aplikasi diambil.")


def fetch_reviews(app_id, max_reviews):
    print("Mengambil ulasan...")
    all_reviews = []
    batch_size = 100  # Jumlah ulasan per batch

    while len(all_reviews) < max_reviews:
        print(f"Fetching reviews... Total reviews so far: {len(all_reviews)}")

        # Ambil ulasan dalam batch
        reviews = reviews_all(app_id, lang="en", country="us", count=batch_size)

        if not reviews:
            print("No reviews returned. Exiting loop.")
            break

        # Cek dan cetak jumlah ulasan yang diambil dalam iterasi ini
        fetched_reviews = len(reviews)
        print(f"Fetched {fetched_reviews} reviews in this batch.")

        all_reviews.extend(reviews)

        # Jika jumlah ulasan yang diambil melebihi batas maksimum, keluar dari loop
        if len(all_reviews) >= max_reviews:
            print(f"Reached maximum reviews limit: {max_reviews}. Exiting loop.")
            break

        # Cek jika tidak ada ulasan lagi
        if fetched_reviews < batch_size:
            print("Fewer reviews returned than requested. Exiting loop.")
            break

    # Cetak total ulasan yang diambil
    print(f"Total ulasan diambil: {len(all_reviews)}")
    return all_reviews[:max_reviews]


# Ambil ulasan dengan batas 1000
reviews = fetch_reviews(app_id, 1000)
print("Ulasan berhasil diambil.")


# Preprocessing teks
def preprocess_text(text):
    if text is None:
        return ""
    text = text.lower()
    text = text.translate(str.maketrans("", "", string.punctuation))
    text = re.sub(r"\d+", "", text)
    return text


# Initialize VADER sentiment analyzer
analyzer = SentimentIntensityAnalyzer()


# Function to classify sentiment using VADER
def get_vader_sentiment(text):
    sentiment_dict = analyzer.polarity_scores(text)
    if sentiment_dict["compound"] >= 0.05:
        return "positive", sentiment_dict["compound"]
    elif sentiment_dict["compound"] <= -0.05:
        return "negative", sentiment_dict["compound"]
    else:
        return "neutral", sentiment_dict["compound"]


print("Memproses data aplikasi...")
# Insert application data
app_data_dict = {
    "name": app_data["title"],
    "category": app_data["genre"],
    "desc": app_data["description"],
    "average_rating": app_data["score"],
    "total_reviews": app_data["reviews"],
}

app_data_df = pd.DataFrame([app_data_dict])
app_data_df.to_sql("aplications", db_engine, if_exists="append", index=False)
print("Data aplikasi berhasil dimasukkan.")

print("Mengambil ID aplikasi yang baru dimasukkan...")
# Dapatkan ID aplikasi yang baru dimasukkan
with db_engine.connect() as conn:
    result = conn.execute(text("SELECT id FROM aplications ORDER BY id DESC LIMIT 1"))
    app_id_db = result.fetchone()[0]
print(f"ID aplikasi yang baru dimasukkan: {app_id_db}")

print("Menyimpan data review ke database...")
# Menyimpan data review ke database
reviews_data = []
sentiments_data = []
for review in reviews:
    if review["content"] is None:
        continue  # Skip reviews with no content

    preprocessed_text = preprocess_text(review["content"])
    sentiment, sentiment_score = get_vader_sentiment(preprocessed_text)

    reviews_data.append(
        {
            "application_id": app_id_db,
            "user_name": review["userName"],
            "rating": review["score"],
            "review_text": review["content"],
            "sentiment": sentiment,  # Predicted sentiment
        }
    )

    sentiments_data.append(
        {
            "review_id": None,  # Placeholder; we'll update it later
            "score": sentiment_score,
        }
    )

reviews_df = pd.DataFrame(reviews_data)
reviews_df.to_sql("reviews", db_engine, if_exists="append", index=False)
print("Data review berhasil dimasukkan.")

print("Memperbarui data sentimen dengan ID review...")
# Update sentiment data with the actual review IDs
with db_engine.connect() as conn:
    for index, review_row in reviews_df.iterrows():
        review_id_db = conn.execute(
            text(
                "SELECT id FROM reviews WHERE application_id=:app_id AND review_text=:review_text"
            ),
            {"app_id": app_id_db, "review_text": review_row["review_text"]},
        ).fetchone()[0]

        sentiments_data[index]["review_id"] = review_id_db

    sentiments_df = pd.DataFrame(sentiments_data)
    sentiments_df.to_sql("sentimens", db_engine, if_exists="append", index=False)
print("Data sentimen berhasil diperbarui dan dimasukkan ke database.")

print("Data berhasil dimasukkan ke database.")
