from flask import Flask, request, jsonify
import subprocess
from flask_cors import CORS

app = Flask(__name__)
CORS(app)


@app.route("/scrape", methods=["POST"])
def scrape():
    user_input = request.json.get("app_select")
    print(f"Received input: {user_input}")  # Debugging line

    # Periksa apakah input adalah string yang sesuai
    if user_input not in ["1", "2", "3"]:
        return jsonify({"error": "Invalid input"}), 400

    process = subprocess.Popen(
        ["python", "flask_app/scrapping.py", user_input],
        stdout=subprocess.PIPE,
        stderr=subprocess.PIPE,
    )

    stdout, stderr = process.communicate()
    print(f"Process stdout: {stdout.decode('utf-8')}")  # Debugging line
    print(f"Process stderr: {stderr.decode('utf-8')}")  # Debugging line

    if process.returncode == 0:
        return jsonify(
            {
                "message": "Scraping started successfully",
                "output": stdout.decode("utf-8"),
            }
        )
    else:
        return jsonify({"error": stderr.decode("utf-8")}), 500


if __name__ == "__main__":
    app.run(debug=True)
