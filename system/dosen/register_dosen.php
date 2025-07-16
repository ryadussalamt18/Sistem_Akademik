<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Dosen</title>
    <link rel="stylesheet" href="global_css/upload.css">
    <script>
        function updateProdi() {
            const fakultas = document.getElementById('fakultas').value;
            const prodiSelect = document.getElementById('prodi');
            prodiSelect.innerHTML = '';

            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.text = 'Pilih Prodi';
            prodiSelect.add(defaultOption);

            if (fakultas === 'FAKULTAS TEKNOLOGI INFORMASI') {
                const option1 = document.createElement('option');
                option1.value = 'Informatika';
                option1.text = 'Informatika';
                prodiSelect.add(option1);

                const option2 = document.createElement('option');
                option2.value = 'Sistem Informasi';
                option2.text = 'Sistem Informasi';
                prodiSelect.add(option2);

                const option3 = document.createElement('option');
                option3.value = 'Sistem Komputer';
                option3.text = 'Sistem Komputer';
                prodiSelect.add(option3);

            } else if (fakultas === 'FAKULTAS TEKNIK') {
                const option1 = document.createElement('option');
                option1.value = 'Industri';
                option1.text = 'Industri';
                prodiSelect.add(option1);

                const option2 = document.createElement('option');
                option2.value = 'Kimia';
                option2.text = 'Kimia';
                prodiSelect.add(option2);

                const option3 = document.createElement('option');
                option3.value = 'Sipil';
                option3.text = 'Sipil';
                prodiSelect.add(option3);

            } else if (fakultas === 'FAKULTAS HUKUM') {
                const option = document.createElement('option');
                option.value = 'Hukum';
                option.text = 'Hukum';
                prodiSelect.add(option);
            }

            updateKodeDosen();
        }

        function updateKodeDosen() {
            const fakultas = document.getElementById('fakultas').value;
            const prodiSelect = document.getElementById('prodi');
            const kodeDosenField = document.getElementById('kode_dosen');

            let kodeFakultas = '';
            let kodeProdi = '';

            switch (fakultas) {
                case 'FAKULTAS TEKNOLOGI INFORMASI':
                    kodeFakultas = 'TI';
                    switch (prodiSelect.value) {
                        case 'Informatika':
                            kodeProdi = '111';
                            break;
                        case 'Sistem Informasi':
                            kodeProdi = '222';
                            break;
                        case 'Sistem Komputer':
                            kodeProdi = '333';
                            break;
                    }
                    break;
                case 'FAKULTAS TEKNIK':
                    kodeFakultas = 'TK';
                    switch (prodiSelect.value) {
                        case 'Industri':
                            kodeProdi = '777';
                            break;
                        case 'Kimia':
                            kodeProdi = '555';
                            break;
                        case 'Sipil':
                            kodeProdi = '999';
                            break;
                    }
                    break;
                case 'FAKULTAS HUKUM':
                    kodeFakultas = 'HK';
                    switch (prodiSelect.value) {
                        case 'Hukum':
                            kodeProdi = '888';
                            break;
                    }
                    break;
            }

            const kodeDosen = `${kodeFakultas}-${kodeProdi}`;
            kodeDosenField.value = kodeDosen;
        }

        function registerDosen(event) {}
    </script>
</head>

<body>
    <div class="container">
        <h1>Form Pendaftaran Dosen</h1>
        <form id="registerForm" action="process_register_dosen.php" method="POST" onsubmit="registerDosen(event)">
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
                <label for="tanggal_lahir">Tanggal Lahir:</label>
                <input type="date" id="tanggal_lahir" name="tanggal_lahir" required>
            </div>
            <div class="form-group">
                <label for="alamat">Alamat:</label>
                <textarea id="alamat" name="alamat" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="kode_dosen">Kode Dosen:</label>
                <input type="text" id="kode_dosen" name="kode_dosen" readonly required>
            </div>
            <button type="submit">Submit</button>
            <p>Sudah Punya Akun? <a href="login_dosen.php" class="btn btn-primary btn-lg">Kembali ke login</a></p>
        </form>
    </div>
</body>

</html>