from google_play_scraper import app, reviews_all
import pandas as pd

# ID aplikasi di Google Play Store
app_id = 'com.gojek.app'

# Mengambil data aplikasi
app_data = app(app_id)
print("App Data:")
print(f"Name: {app_data['title']}")
print(f"Developer: {app_data['developer']}")
print(f"Rating: {app_data['score']}")
print(f"Reviews: {app_data['reviews']}")
print(f"Description: {app_data['description']}")

# Mengambil ulasan aplikasi
reviews = reviews_all(app_id)
print("Reviews:")
for review in reviews[:5]:  # Tampilkan 5 ulasan pertama
    print(f"Review by {review['userName']}: {review['content']}")
    print(f"Rating: {review['score']}")
    print(f"Date: {review['at']}")
    print("-" * 40)

# Menyimpan data ke CSV
app_data_df = pd.DataFrame([app_data])
app_data_df.to_csv('app_data.csv', index=False)

reviews_df = pd.DataFrame(reviews)
reviews_df.to_csv('app_reviews.csv', index=False)
