<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Windi Florist - Toko Bunga & Buket</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Header & Navigasi -->
    <header>
        <div class="logo">🌸 Windi Florist</div>
        <nav>
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="#katalog">Katalog</a></li>
                <li><a href="#tentang">Tentang Kami</a></li>
                <li><a href="#kontak">Kontak</a></li>
                <li><a href="admin.php" style="color: #d63384; font-weight: bold;">[ Admin Panel ]</a></li>
            </ul>
        </nav>
    </header>

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="hero-content">
            <h1>Rangkaian Bunga Indah untuk Momen Spesial Anda</h1>
            <p>Menyediakan buket wisuda, karangan bunga ucapan, dan bunga segar dengan harga terjangkau.</p>
            <a href="#katalog" class="btn">Lihat Katalog</a>
        </div>
    </section>

    <!-- Katalog Produk (Diisi secara dinamis oleh JavaScript via API) -->
    <section id="katalog" class="katalog">
        <h2>Katalog Produk</h2>
        <div class="produk-grid" id="produk-container">
            <p>Memuat data produk dari API...</p>
        </div>
    </section>

    <!-- Tentang Kami -->
    <section id="tentang" class="tentang">
        <h2>Mengapa Memilih Windi Florist?</h2>
        <div class="keunggulan-grid">
            <div class="item">
                <h3>🌹 Bunga Segar</h3>
                <p>Bunga dipetik langsung dari petani lokal terbaik.</p>
            </div>
            <div class="item">
                <h3>⚡ Pengiriman Cepat</h3>
                <p>Siap kirim di hari yang sama untuk area sekitar.</p>
            </div>
            <div class="item">
                <h3>🎨 Bisa Kustom</h3>
                <p>Bisa kustom jenis bunga, warna, dan kartu ucapan.</p>
            </div>
        </div>
    </section>

    <!-- Kontak -->
    <section id="kontak" class="kontak">
        <h2>Hubungi Kami</h2>
        <p>Ingin pesan bunga kustom atau tanya stok? Klik tombol di bawah ini untuk mengobrol dengan kami di WhatsApp.</p>
        <a href="https://wa.me/6285753044724" class="btn-wa" target="_blank">💬 Chat WhatsApp Admin</a>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2026 Windi Florist - Tugas Pemrograman Web (Windi Bonde - UG54B25006)</p>
    </footer>

    <!-- Script JavaScript untuk memanggil REST API -->
    <script>
        async function muatProdukDariAPI() {
            const container = document.getElementById('produk-container');
            try {
                const response = await fetch('api/products.php');
                const result = await response.json();

                if (response.ok && result.data && result.data.length > 0) {
                    container.innerHTML = '';
                    result.data.forEach(produk => {
                        const hargaFormatted = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(produk.price);
                        const waText = encodeURIComponent(`Halo Windi Florist, saya ingin pesan ${produk.name}`);
                        const imgUrl = produk.image_url || 'https://images.unsplash.com/photo-1561181286-d3fee7d55364?w=400';
                        const katBadge = produk.category_name ? `<small style="color: #d63384; font-weight: 600; margin-bottom: 5px; display: block;">Category: ${produk.category_name}</small>` : '';

                        const card = `
                            <div class="produk-card">
                                <img src="${imgUrl}" alt="${produk.name}">
                                <h3>${produk.name}</h3>
                                ${katBadge}
                                <p>${produk.description || ''}</p>
                                <span class="harga">${hargaFormatted}</span>
                                <a href="https://wa.me/6285753044724?text=${waText}" class="btn-sm" target="_blank">Pesan via WA</a>
                            </div>
                        `;
                        container.innerHTML += card;
                    });
                } else {
                    container.innerHTML = '<p>Belum ada produk yang tersedia saat ini.</p>';
                }
            } catch (error) {
                console.error('Gagal mengambil data API:', error);
                container.innerHTML = '<p style="color: red;">Gagal memuat data produk dari API.</p>';
            }
        }

        document.addEventListener('DOMContentLoaded', muatProdukDariAPI);
    </script>

</body>
</html>