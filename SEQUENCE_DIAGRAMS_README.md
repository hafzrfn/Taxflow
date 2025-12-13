# Sequence Diagrams - Sistem Informasi Manajemen Pajak

File ini berisi diagram sequence PlantUML untuk berbagai aktivitas dalam sistem SIM Pajak.

## Cara Menggunakan

### 1. Menggunakan PlantUML Online
1. Buka [PlantUML Online Server](http://www.plantuml.com/plantuml/uml/)
2. Copy-paste kode dari file `sequence-diagrams.puml`
3. Pilih diagram yang ingin dilihat (setiap diagram dimulai dengan `@startuml` dan diakhiri dengan `@enduml`)
4. Diagram akan otomatis dirender

### 2. Menggunakan VS Code Extension
1. Install extension "PlantUML" di VS Code
2. Buka file `sequence-diagrams.puml`
3. Tekan `Alt+D` atau klik kanan dan pilih "Preview Current Diagram"

### 3. Menggunakan Command Line
```bash
# Install PlantUML (Java required)
# Download from: https://plantuml.com/download

# Generate PNG untuk semua diagram
java -jar plantuml.jar sequence-diagrams.puml

# Generate diagram tertentu (contoh: Registration)
java -jar plantuml.jar -tname Registration sequence-diagrams.puml
```

## Daftar Diagram

File `sequence-diagrams.puml` berisi 8 diagram sequence:

1. **Registration (Registrasi)** - Alur registrasi wajib pajak dengan verifikasi Dukcapil
2. **Login** - Alur login user
3. **Isi Objek Pajak** - Alur pengisian objek pajak dan pembuatan tagihan otomatis
4. **Bayar Tagihan** - Alur pembayaran tagihan melalui e-Billing
5. **e-Filing SPT** - Alur pengajuan SPT elektronik
6. **Pengaduan** - Alur pengajuan pengaduan
7. **Admin Verifikasi SPT** - Alur verifikasi SPT oleh admin
8. **Payment Callback** - Alur webhook callback dari payment gateway

## Catatan

- Semua diagram menggunakan tema sederhana (plain theme) dengan background putih
- Diagram dirancang untuk mudah dipahami dan tidak terlalu kompleks
- Setiap diagram mencerminkan alur yang sebenarnya dalam kode aplikasi


