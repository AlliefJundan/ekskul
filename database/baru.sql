-- Insert 5 data ke tabel kelas
INSERT INTO `kelas` (`id_kelas`, `kelas`, `jurusan`, `nomor_kelas`) VALUES
(1, '10', 'PPLG', '1'),
(2, '10', 'DKV', '2'),
(3, '11', 'AKT', '1'),
(4, '12', 'ANM', '3'),
(5, '12', 'BDP', '2');

-- Insert 10 data ke tabel users, dengan 1 di antaranya sebagai admin
INSERT INTO `users` (`nama`, `username`, `password`, `id_kelas`, `role`) VALUES
('Admin User', '2223607653', '$2y$12$7ueCKGRw1ooWKL.tWgCm8Ow.1vKkQHItSp7yIX0csnHk3frmkQQme', '3', 'admin'),
('User One', '2223607641', '$2y$12$7ueCKGRw1ooWKL.tWgCm8Ow.1vKkQHItSp7yIX0csnHk3frmkQQme', '1', 'user'),
('User Two', '2223607083', '$2y$12$7ueCKGRw1ooWKL.tWgCm8Ow.1vKkQHItSp7yIX0csnHk3frmkQQme', '4', 'user'),
('User Three', '2223607902', '$2y$12$7ueCKGRw1ooWKL.tWgCm8Ow.1vKkQHItSp7yIX0csnHk3frmkQQme', '2', 'user'),
('User Four', '2223607618', '$2y$12$7ueCKGRw1ooWKL.tWgCm8Ow.1vKkQHItSp7yIX0csnHk3frmkQQme', '5', 'user'),
('User Five', '2223607106', '$2y$12$7ueCKGRw1ooWKL.tWgCm8Ow.1vKkQHItSp7yIX0csnHk3frmkQQme', '5', 'user'),
('User Six', '2223607457', '$2y$12$7ueCKGRw1ooWKL.tWgCm8Ow.1vKkQHItSp7yIX0csnHk3frmkQQme', '1', 'user'),
('User Seven', '2223607934', '$2y$12$7ueCKGRw1ooWKL.tWgCm8Ow.1vKkQHItSp7yIX0csnHk3frmkQQme', '2', 'user'),
('User Eight', '2223607993', '$2y$12$7ueCKGRw1ooWKL.tWgCm8Ow.1vKkQHItSp7yIX0csnHk3frmkQQme', '3', 'user'),
('User Nine', '2223607795', '$2y$12$7ueCKGRw1ooWKL.tWgCm8Ow.1vKkQHItSp7yIX0csnHk3frmkQQme', '2', 'user'),
('Rizla', '123456', '$2y$12$7ueCKGRw1ooWKL.tWgCm8Ow.1vKkQHItSp7yIX0csnHk3frmkQQme', '2', 'user');

-- Insert 2 data ke tabel ekskul
INSERT INTO `ekskul` (`nama_ekskul`, `slug`, `gambar`, `deskripsi`) VALUES
('Basket', 'basket', 'pp_ekskul/VmxnbbwGnCUi0U9kWhkWZRW2e9uMhvjG8Qbt1CzO.jpg', 'Ekstrakurikuler Basket'),
('Paskibra', 'paskibra', 'pp_ekskul/Osf5jstKX8niY7kltQUvMuv4oB3wSjza9vxBMjIX.png', 'Ekstrakurikuler '),
('Futsal', 'futsal', 'pp_ekskul/Osf5jstKX8niY7kltQUvMuv4oB3wSjza9vxBMjIX.png', 'Ekstrakurikuler Futsal');

-- Insert 5 data ke tabel jabatan
INSERT INTO `jabatan` (`nama_jabatan`, `slug`) VALUES
('Pembina', 'pembina'),
('Ketua', 'ketua'),
('Sekertaris', 'sekertaris'),
('Bendahara', 'bendahara');

-- Insert 10 data ke tabel ekskul_user dengan aturan jabatan
INSERT INTO `ekskul_user` (`user_id`, `ekskul_id`, `jabatan`, `created_at`, `updated_at`) VALUES
(2, 1, 1, NOW(), NOW()), -- Ketua Basket
(3, 1, 2, NOW(), NOW()), -- Wakil Ketua Basket
(4, 1, 3, NOW(), NOW()), -- Sekretaris Basket
(5, 1, 4, NOW(), NOW()), -- Bendahara Basket
(6, 1, null, NOW(), NOW()), -- Anggota Basket
(7, 2, 1, NOW(), NOW()), -- Ketua Paskibra
(8, 2, 2, NOW(), NOW()), -- Wakil Ketua Paskibra
(9, 2, 3, NOW(), NOW()), -- Sekretaris Paskibra
(10, 2, 4, NOW(), NOW()), -- Bendahara Paskibra
(1, 2, null, NOW(), NOW()), -- Admin ikut dalam Paskibra tanpa jabatan
(11, 3, 2, NOW(), NOW()); -- Admin ikut dalam Paskibra tanpa jabatan

INSERT INTO `pendaftaran` (`id_user`, `id_ekskul`, `status`) VALUES
(2, 1, 'diterima'),
(3, 1, 'diterima'),
(4, 1, 'diterima'),
(5, 1, 'diterima'),
(6, 1, 'diterima'),
(7, 2, 'diterima'),
(8, 2, 'diterima'),
(9, 2, 'diterima'),
(10, 2, 'diterima'),
(1, 2, 'diterima'),
(11, 3, 'diterima');