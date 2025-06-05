# Gunakan image dasar yang sudah ada Python-nya
FROM python:3.10-slim

# Set direktori kerja di dalam container
WORKDIR /app

# Salin semua file dari repo ke dalam container
COPY . .

# Install semua dependensi dari requirements.txt jika ada
RUN pip install --no-cache-dir -r requirements.txt

# Jalankan file utama
CMD ["python", "main.py"]
