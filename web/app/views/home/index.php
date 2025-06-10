<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['judul']; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
    :root {
        --primary-color: #2ECC71;
        --primary-dark: #27AE60;
        --secondary-color: #6c757d;
        --light-color: #ffffff;
        --dark-color: #212529;
        --gray-bg: #f8f9fa;
        --gradient-start: #2ECC71;
        --gradient-end: #3498DB;
        --shadow: 0 10px 30px rgba(46, 204, 113, 0.2);
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Poppins', sans-serif;
        line-height: 1.6;
        color: var(--dark-color);
        background-color: #f9f9f9;
    }

    .wrapper {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .main-gray-wrapper {
        background-color: var(--gray-bg);
        padding: 40px 0;
        border-radius: 0 0 15px 15px;
        margin-top: -20px;
        box-shadow: inset 0 0 15px rgba(0, 0, 0, 0.03);
        position: relative;
        z-index: 1;
    }

    header {
        color: whitesmoke;
        padding: 120px 20px;
        text-align: center;
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
        border-radius: 0 0 15px 15px;
        box-shadow: var(--shadow);
    }

    header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none"><path fill="rgba(255,255,255,0.05)" d="M0,0 L100,0 L100,100 Q50,80 0,100 Z"></path></svg>');
        background-size: 100% 100%;
        opacity: 0.3;
    }

    header h1 {
        font-size: 3rem;
        margin-bottom: 20px;
        animation: fadeInDown 1s ease;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        position: relative;
    }

    header p {
        font-size: 1.4rem;
        max-width: 700px;
        margin: 0 auto 30px;
        opacity: 0.9;
        animation: fadeInUp 1s ease 0.3s forwards;
        position: relative;
    }

    .cta-button {
        display: inline-block;
        background-color: white;
        color: var(--primary-dark);
        padding: 14px 35px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        margin: 10px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        animation: fadeIn 1s ease 0.6s forwards;
        opacity: 0;
        position: relative;
        overflow: hidden;
        border: none;
        font-size: 1.1rem;
    }

    .cta-button::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(rgba(255, 255, 255, 0.3), rgba(255, 255, 255, 0));
        transform: translateY(-100%);
        transition: transform 0.3s ease;
    }

    .cta-button:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    }

    .cta-button:hover::after {
        transform: translateY(0);
    }

    .cta-button.secondary {
        background-color: transparent;
        color: white;
        border: 2px solid white;
    }

    .cta-button.secondary:hover {
        background-color: rgba(255, 255, 255, 0.1);
    }

    .main-content {
        padding: 40px 20px;
        text-align: center;
        max-width: 1200px;
        margin: 0 auto;
    }

    .main-content h2 {
        font-size: 2.5rem;
        margin-bottom: 25px;
        color: var(--primary-dark);
        position: relative;
        display: inline-block;
    }

    .main-content h2::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background: var(--primary-color);
        border-radius: 2px;
    }

    .main-content p {
        font-size: 1.2rem;
        color: var(--secondary-color);
        max-width: 800px;
        margin: 0 auto 50px;
    }

    .features {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 30px;
        margin-top: 50px;
    }

    .feature-card {
        background: white;
        border-radius: 15px;
        padding: 40px 30px;
        width: 320px;
        box-shadow: 0 10px 30px rgba(46, 204, 113, 0.1);
        transition: all 0.4s ease;
        position: relative;
        overflow: hidden;
        border-top: 3px solid var(--primary-color);
    }

    .feature-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 5px;
        background: var(--primary-color);
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.4s ease;
    }

    .feature-card:hover {
        transform: translateY(-15px);
        box-shadow: 0 15px 40px rgba(46, 204, 113, 0.2);
    }

    .feature-card:hover::before {
        transform: scaleX(1);
    }

    .feature-icon {
        font-size: 3rem;
        color: var(--primary-color);
        margin-bottom: 25px;
        transition: transform 0.3s ease;
    }

    .feature-card:hover .feature-icon {
        transform: scale(1.1) rotate(5deg);
    }

    .feature-card h3 {
        margin-bottom: 20px;
        color: var(--dark-color);
        font-size: 1.5rem;
    }

    .feature-card p {
        font-size: 1.1rem;
        margin-bottom: 0;
    }

    footer {
        background-color: var(--light-color);
        color: var(--dark-color);
        text-align: center;
        padding: 40px 20px;
        margin-top: 50px;
        border-top: 1px solid rgba(0, 0, 0, 0.1);
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @media (max-width: 768px) {
        header {
            padding: 80px 20px;
        }

        header h1 {
            font-size: 2.2rem;
            line-height: 1.3;
        }

        header p {
            font-size: 1.1rem;
            margin-bottom: 25px;
        }

        .cta-button {
            padding: 12px 25px;
            font-size: 1rem;
        }

        .features {
            flex-direction: column;
            align-items: center;
        }

        .feature-card {
            width: 100%;
            max-width: 350px;
        }

        .main-gray-wrapper {
            padding: 30px 0;
            margin-top: -15px;
        }

        .main-content h2 {
            font-size: 2rem;
        }
    }
    </style>
</head>

<body>

    <div class="wrapper">
        <header>
            <h1><?= $data['welcome']; ?></h1>
            <p><?= $data['catch_phrase']; ?></p>
            <a href="<?= BASEURL ?>/users/register" class="cta-button">Daftar Sekarang</a>
            <a href="<?= BASEURL ?>/users/auth" class="cta-button secondary">Masuk</a>
        </header>

        <!-- Wrapper abu-abu untuk konten utama -->
        <div class="main-gray-wrapper">
            <div class="main-content">
                <h2>Selamat datang di Diajar!</h2>
                <p>Di sini kamu bisa belajar banyak hal untuk meningkatkan skill dan pengetahuanmu dengan metode
                    pembelajaran yang menyenangkan dan efektif.</p>

                <div class="features">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fas fa-graduation-cap"></i></div>
                        <h3>Kursus Berkualitas</h3>
                        <p>Materi pembelajaran disusun oleh para ahli di bidangnya untuk memastikan kamu mendapatkan
                            pengetahuan terbaik.</p>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon"><i class="fas fa-user-tie"></i></div>
                        <h3>Pengajar Profesional</h3>
                        <p>Belajar langsung dari praktisi dan akademisi yang berpengalaman di industri masing-masing.
                        </p>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon"><i class="fas fa-laptop-code"></i></div>
                        <h3>Fleksibel</h3>
                        <p>Belajar kapan saja, di mana saja sesuai dengan waktu luang dan ritme belajarmu sendiri.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; <?= date('Y'); ?> Diajar. All rights reserved.</p>
    </footer>

</body>

</html>