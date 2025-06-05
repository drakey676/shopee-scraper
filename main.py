import requests
from bs4 import BeautifulSoup

def get_price_from_url(url):
    headers = {
        "User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64)",
        "Accept-Language": "id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7",
    }

    try:
        response = requests.get(url, headers=headers)
        soup = BeautifulSoup(response.text, "html.parser")

        # Cari data JSON yang memuat harga
        scripts = soup.find_all("script")
        for script in scripts:
            if "itemid" in script.text and "price" in script.text:
                if "rawData" in script.text:
                    raw = script.text
                    start = raw.find('{')
                    json_data = raw[start:]
                    if '"price"' in json_data:
                        # Ekstrak harga kasar dari string (nanti bisa diperbaiki)
                        price_start = json_data.find('"price":') + 8
                        price_end = json_data.find(",", price_start)
                        price = json_data[price_start:price_end]
                        return price
        return "Harga tidak ditemukan"
    except Exception as e:
        return f"Error: {e}"

with open("urls.txt", "r") as file:
    urls = [line.strip() for line in file.readlines() if line.strip()]

for url in urls:
    print(f"Scraping: {url}")
    price = get_price_from_url(url)
    print(f"Harga: {price}")
