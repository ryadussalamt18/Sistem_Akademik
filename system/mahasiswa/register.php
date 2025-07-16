<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pendaftaran Mahasiswa</title>
    <link rel="stylesheet" href="global_css/dashboard.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffa500;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="date"],
        textarea,
        select {
            width: calc(100% - 22px);
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
            margin-top: 4px;
        }

        select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url('data:image/svg+xml;utf8,<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/></svg>');
            background-repeat: no-repeat;
            background-position-x: calc(100% - 10px);
            background-position-y: 50%;
            padding-right: 30px;
        }

        button {
            padding: 12px 300px;
            background-color: #ffa500;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            display: block;
            margin: 20px auto;
        }

        button:hover {
            background-color: #e68a00;
        }
    </style>
    <script>
        function updateProdi() {
            const fakultas = document.getElementById('fakultas').value;
            const prodi = document.getElementById('prodi');
            prodi.innerHTML = '';

            if (fakultas === 'FAKULTAS TEKNOLOGI INFORMASI') {
                const option = document.createElement('option');
                option.value = 'Pilih Prodi';
                option.text = 'Pilih Prodi';
                prodi.add(option);

                const option1 = document.createElement('option');
                option1.value = 'Informatika';
                option1.text = 'Informatika';
                prodi.add(option1);

                const option2 = document.createElement('option');
                option2.value = 'Sistem Informasi';
                option2.text = 'Sistem Informasi';
                prodi.add(option2);

                const option3 = document.createElement('option');
                option3.value = 'Sistem Komputer';
                option3.text = 'Sistem Komputer';
                prodi.add(option3);

            } else if (fakultas === 'FAKULTAS TEKNIK') {
                const option = document.createElement('option');
                option.value = 'Pilih Prodi';
                option.text = 'Pilih Prodi';
                prodi.add(option);

                const option1 = document.createElement('option');
                option1.value = 'Industri';
                option1.text = 'Industri';
                prodi.add(option1);

                const option2 = document.createElement('option');
                option2.value = 'Kimia';
                option2.text = 'Kimia';
                prodi.add(option2);

                const option3 = document.createElement('option');
                option3.value = 'Sipil';
                option3.text = 'Sipil';
                prodi.add(option3);

            } else if (fakultas === 'FAKULTAS HUKUM') {
                const option = document.createElement('option');
                option.value = 'Pilih Prodi';
                option.text = 'Pilih Prodi';
                prodi.add(option);

                const option1 = document.createElement('option');
                option1.value = 'Hukum';
                option1.text = 'Hukum';
                prodi.add(option1);
            }
        }
    </script>
</head>

<body>
    <div class="container">
        <h1>Form Pendaftaran Mahasiswa</h1>
        <form action="process_register.php" method="POST">
            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" id="nama" name="nama" required>
            </div>
            <div class="form-group">
                <label for="fakultas">Fakultas:</label>
                <select id="fakultas" name="fakultas" required onchange="updateProdi()">
                    <option value="">Pilih Fakultas</option>
                    <option value="FAKULTAS TEKNIK">Fakultas Teknik</option>
                    <option value="FAKULTAS TEKNOLOGI INFORMASI">Fakultas Teknologi Informasi</option>
                    <option value="FAKULTAS HUKUM">Fakultas Hukum</option>
                </select>
            </div>
            <div class="form-group">
                <label for="prodi">Prodi:</label>
                <select id="prodi" name="prodi" required onchange="updateKodeDosen()">
                    <option value="">Pilih Prodi</option>
                </select>
            </div>
            <div class="form-group">
                <label for="jenis_kelamin">Jenis Kelamin:</label>
                <select id="jenis_kelamin" name="jenis_kelamin" required>
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>
            <div class="form-group">
                <label for="tanggal_lahir">Tanggal Lahir</label>
                <input type="date" id="tanggal_lahir" name="tanggal_lahir" required>
            </div>
            <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea id="alamat" name="alamat" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Submit</button>
            <p>Sudah Punya Akun? <a href="login.php" class="btn btn-primary btn-lg">Kembali ke login</a></p>
        </form>
    </div>
</body>

</html>