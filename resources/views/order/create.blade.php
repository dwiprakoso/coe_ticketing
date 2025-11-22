<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Order Form - Event Management</title><!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

    <style>
        :root {
            --primary: #D4A574;
            /* Gold color */
            --primary-dark: #B8935F;
            /* Darker gold for hover */
            --success: #D4A574;
            /* Gold for price */
            --dark: #2C2C2C;
            /* Dark gray */
            --white: #ffffff;
            --gray-100: #F5F5F5;
            /* Light gray background */
            --gray-200: #E8E8E8;
            /* Light border */
            --gray-300: #D1D1D1;
            /* Medium border */
            --gray-600: #666666;
            /* Medium gray text */
            --gray-700: #4A4A4A;
            /* Darker gray text */
            --gray-900: #2C2C2C;
            /* Very dark gray */
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--gray-100);
            color: var(--gray-700);
            font-size: 14px;
            line-height: 1.5;
        }

        /* Minimal Navbar */
        .navbar {
            background: var(--dark);
            border-bottom: 1px solid var(--gray-600);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            padding: 1rem 0;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary);
            text-decoration: none;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .navbar-brand i {
            color: var(--primary);
            margin-right: 0.5rem;
        }

        .navbar .container {
            display: flex;
            justify-content: center;
        }

        /* Cards */
        .card {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            margin-bottom: 1.5rem;
        }

        .card-body {
            padding: 2rem;
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }

        .card-title i {
            color: var(--primary);
            margin-right: 0.75rem;
        }

        /* Breadcrumb */
        .breadcrumb {
            background-color: transparent;
            padding: 0;
            margin-bottom: 2rem;
            font-size: 14px;
        }

        .breadcrumb-item {
            color: var(--gray-600);
        }

        .breadcrumb-item.active {
            color: var(--gray-700);
            font-weight: 600;
        }

        .breadcrumb-item a {
            color: var(--primary);
            text-decoration: none;
        }

        .breadcrumb-item a:hover {
            color: var(--primary-dark);
        }

        /* Form Controls */
        .form-label {
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 0.5rem;
            font-size: 14px;
        }

        .form-control,
        .form-select {
            border: 1px solid var(--gray-300);
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-size: 14px;
            transition: all 0.3s ease;
            background-color: var(--white);
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(212, 165, 116, 0.15);
            background-color: var(--white);
        }

        .form-control.is-invalid {
            border-color: #f1416c;
        }

        .text-danger {
            color: #f1416c !important;
            font-size: 12px;
            margin-top: 0.25rem;
        }

        /* Input Groups */
        .input-group-text {
            background-color: var(--gray-200);
            border-color: var(--gray-300);
            color: var(--gray-600);
            font-size: 14px;
        }

        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border: none;
            color: var(--white);
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: 6px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            box-shadow: 0 4px 12px rgba(212, 165, 116, 0.3);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark) 0%, #A67C52 100%);
            transform: translateY(-2px);
            color: var(--white);
            box-shadow: 0 6px 20px rgba(212, 165, 116, 0.4);
        }

        .btn-primary i {
            margin-right: 0.5rem;
        }

        .btn-secondary {
            background-color: var(--gray-200);
            border: 1px solid var(--gray-300);
            color: var(--gray-700);
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: 6px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            text-decoration: none;
        }

        .btn-secondary:hover {
            background-color: var(--gray-300);
            border-color: var(--gray-700);
            color: var(--gray-700);
        }

        .btn-secondary i {
            margin-right: 0.5rem;
        }

        /* Event Info Card */
        .event-info {
            background-color: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .event-info img {
            border-radius: 8px;
        }

        .event-info h5 {
            color: var(--dark);
            font-weight: 700;
            margin-bottom: 0.75rem;
            font-size: 1.125rem;
        }

        .event-info .text-muted {
            color: var(--gray-600) !important;
            font-size: 14px;
        }

        /* Ticket Selection */
        .ticket-selection {
            background-color: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .ticket-selection h6 {
            color: var(--dark);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .price-display {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary);
        }

        /* Section Headers */
        .section-header {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--dark);
        }

        .section-header i {
            color: var(--primary);
            margin-right: 0.5rem;
        }

        /* Jersey Size Grid */
        .jersey-size-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(70px, 1fr));
            gap: 0.75rem;
            margin-top: 0.75rem;
        }

        .jersey-size-option {
            position: relative;
            text-align: center;
            padding: 1rem 0.5rem;
            border: 1px solid var(--gray-300);
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            background-color: var(--white);
            font-weight: 600;
            font-size: 14px;
        }

        .jersey-size-option:hover {
            border-color: var(--primary);
            background-color: rgba(212, 165, 116, 0.1);
        }

        .jersey-size-option.selected {
            border-color: var(--primary);
            background-color: var(--primary);
            color: var(--white);
        }

        .jersey-size-option input[type="radio"] {
            display: none;
        }

        /* Order Summary */
        .order-summary {
            background-color: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: 8px;
            padding: 2rem;
            position: sticky;
            top: 90px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .order-summary h5 {
            color: var(--dark);
            font-weight: 700;
            margin-bottom: 1.5rem;
            font-size: 1.125rem;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--gray-200);
        }

        .summary-item:last-child {
            border-bottom: none;
        }

        .summary-item span:first-child {
            color: var(--gray-600);
            font-size: 14px;
        }

        .summary-item span:last-child {
            font-weight: 600;
            color: var(--dark);
            font-size: 14px;
        }

        .total-section {
            background-color: var(--gray-100);
            border-radius: 8px;
            padding: 1rem;
            margin: 1rem 0;
        }

        .total-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
        }

        /* Alerts */
        .alert {
            border: none;
            border-radius: 8px;
            font-size: 12px;
            padding: 1rem;
        }

        .alert-info {
            background-color: rgba(212, 165, 116, 0.1);
            color: var(--primary);
            border: 1px solid rgba(212, 165, 116, 0.2);
        }

        .alert-warning {
            background-color: #fff8dd;
            color: #ffc700;
            border: 1px solid #ffeaa7;
        }

        /* Footer */
        .footer {
            background: var(--dark);
            color: var(--gray-600);
            padding: 2rem 0;
            margin-top: 3rem;
            border-top: 3px solid var(--primary);
        }

        .footer h6 {
            color: var(--primary);
            font-weight: 600;
            margin-bottom: 1rem;
        }

        /* Container */
        .container-custom {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .order-summary {
                position: relative;
                top: auto;
                margin-top: 2rem;
            }

            .container-custom {
                padding: 1rem;
            }
        }

        @media (max-width: 768px) {
            .card-body {
                padding: 1.5rem;
            }

            .jersey-size-grid {
                grid-template-columns: repeat(4, 1fr);
            }

            .event-info {
                padding: 1rem;
            }

            .order-summary {
                padding: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="container">
            <a href="#" class="navbar-brand">
                <img src="{{ asset('assets/media/logos/logo.png') }}" alt="Ticketify" height="50" />
            </a>
        </div>
    </nav><!-- Main Content -->
    <div class="container-custom" style="margin-top: 100px;">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('order.index') }}">
                        <i class="fas fa-home me-1"></i>Events
                    </a>
                </li>
                <li class="breadcrumb-item active">Order Form</li>
            </ol>
        </nav>

        <div class="row">
            <!-- Order Form -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">
                            <i class="fas fa-shopping-cart"></i> Form Pemesanan Tiket
                        </h3>

                        <!-- Event Info -->
                        <div class="event-info mb-4">
                            <div class="row align-items-center">
                                <div class="col-md-3">
                                    <img src="{{ $product->avatar ? Storage::url($product->avatar) : 'https://via.placeholder.com/150x100?text=No+Image' }}"
                                        alt="Event" class="img-fluid rounded" />
                                </div>
                                <div class="col-md-9">
                                    <h5>{{ $product->product_name }}</h5>
                                    <p class="text-muted mb-1">
                                        <i class="fas fa-calendar me-2"></i>
                                        {{ \Carbon\Carbon::parse($product->event_date)->translatedFormat('d M Y') }}
                                    </p>
                                    <p class="text-muted mb-0">
                                        <i class="fas fa-map-marker-alt me-2"></i> {{ $product->location }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('order.store') }}" method="POST" id="orderForm" novalidate>
                            @csrf
                            <input type="hidden" name="ticket_id" value="{{ $ticket->id }}" />

                            <div class="mb-3">
                                <label for="nama_lengkap" class="form-label">Nama Lengkap <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap"
                                    required value="{{ old('nama_lengkap') }}" placeholder="Masukkan nama lengkap" />
                                @error('nama_lengkap')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label for="no_handphone" class="form-label">No. Handphone <span
                                        class="text-danger">*</span></label>
                                <input type="tel" class="form-control" id="no_handphone" name="no_handphone"
                                    required value="{{ old('no_handphone') }}" placeholder="08123456789"
                                    pattern="^08\d{8,12}$"
                                    title="Masukkan nomor handphone yang valid, mulai dengan 08 dan 10-14 digit" />
                                @error('no_handphone')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="alamat_lengkap" class="form-label">Alamat<span
                                        class="text-danger">*</span></label>
                                <input type="alamat_lengkap" class="form-control" id="alamat_lengkap"
                                    name="alamat_lengkap" required value="{{ old('alamat_lengkap') }}"
                                    placeholder="Alamat" />
                                @error('alamat_lengkap')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="quantity" class="form-label">Jumlah Tiket <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="quantity" name="quantity" required
                                    min="1" max="5" value="{{ old('quantity', 1) }}" />
                                @error('quantity')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-credit-card"></i> Lanjut ke Pembayaran
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="order-summary">
                    <h5><i class="fas fa-receipt me-2"></i> Ringkasan Pesanan</h5>

                    <div class="summary-item">
                        <span>Kategori Tiket:</span>
                        <span>{{ $ticket->name }}</span>
                    </div>

                    <div class="summary-item">
                        <span>Harga Tiket:</span>
                        <span id="ticketPrice" data-price="{{ $ticket->price }}">
                            Rp {{ number_format($ticket->price, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="summary-item">
                        <span>Biaya Admin (5%):</span>
                        <span id="adminFee">
                            Rp {{ number_format($ticket->price * 0.05, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="total-section">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold">Total:</span>
                            <span class="total-price" id="totalPrice">
                                Rp {{ number_format($ticket->price * 1.05, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h6>Ticketify</h6>
                    <p class="mb-0">Platform terpercaya untuk booking tiket event di Indonesia</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">&copy; 2025 Ticketify. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <script>
        // Fungsi format Rupiah
        function formatRupiah(number) {
            return 'Rp ' + number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

        document.addEventListener('DOMContentLoaded', function() {
            const qtyInput = document.getElementById('quantity');
            const ticketPriceEl = document.getElementById('ticketPrice');
            const adminFeeEl = document.getElementById('adminFee');
            const totalPriceEl = document.getElementById('totalPrice');

            function updatePrices() {
                let price = parseInt(ticketPriceEl.getAttribute('data-price'), 10);
                let qty = parseInt(qtyInput.value, 10);

                if (isNaN(qty) || qty < 1) qty = 1;
                if (qty > 5) qty = 5;

                let ticketTotal = price * qty;
                let adminFee = Math.round(ticketTotal * 0.05);
                let total = ticketTotal + adminFee;

                ticketPriceEl.textContent = formatRupiah(ticketTotal);
                adminFeeEl.textContent = formatRupiah(adminFee);
                totalPriceEl.textContent = formatRupiah(total);
            }

            // Update harga saat halaman load
            updatePrices();

            // Update harga saat quantity berubah
            qtyInput.addEventListener('input', updatePrices);

            // Validasi form (tetap jaga validasi yang sudah ada)
            document.getElementById('orderForm').addEventListener('submit', function(e) {
                let isValid = true;

                // Nama lengkap harus diisi dan minimal 3 karakter
                const nama = document.getElementById('nama_lengkap');
                if (!nama.value.trim() || nama.value.trim().length < 3) {
                    nama.classList.add('is-invalid');
                    isValid = false;
                } else {
                    nama.classList.remove('is-invalid');
                }

                // Email valid
                const email = document.getElementById('email');
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(email.value.trim())) {
                    email.classList.add('is-invalid');
                    isValid = false;
                } else {
                    email.classList.remove('is-invalid');
                }

                // No HP valid sesuai pattern
                const noHp = document.getElementById('no_handphone');
                const noHpPattern = /^08\d{8,12}$/;
                if (!noHpPattern.test(noHp.value.trim())) {
                    noHp.classList.add('is-invalid');
                    isValid = false;
                } else {
                    noHp.classList.remove('is-invalid');
                }

                // Quantity antara 1 sampai 5
                const qtyVal = parseInt(qtyInput.value, 10);
                if (isNaN(qtyVal) || qtyVal < 1 || qtyVal > 5) {
                    qtyInput.classList.add('is-invalid');
                    isValid = false;
                } else {
                    qtyInput.classList.remove('is-invalid');
                }

                if (!isValid) {
                    e.preventDefault();
                    alert('Mohon lengkapi form dengan benar ya!');
                }
            });
        });
    </script>
</body>

</html>
