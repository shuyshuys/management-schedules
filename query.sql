CREATE TABLE mahasiswa (
  id VARCHAR(13) PRIMARY KEY,
  username VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL
);

CREATE TABLE mata_kuliah (
  id_mata_kuliah INT PRIMARY KEY AUTO_INCREMENT,
  id_dosen INT NOT NULL,
  nama_mata_kuliah VARCHAR(50) NOT NULL
);

CREATE TABLE dosen (
  id_dosen INT PRIMARY KEY AUTO_INCREMENT,
  nama_dosen VARCHAR(50) NOT NULL
);

CREATE TABLE tugas (
  id_tugas INT PRIMARY KEY AUTO_INCREMENT,
  id_mata_kuliah INT NOT NULL,
  nama_tugas VARCHAR(50) NOT NULL,
  deskripsi_tugas VARCHAR(255) NOT NULL,
  status_tugas VARCHAR(50) NOT NULL,
  deadline DATE NOT NULL
);

-- Menambahkan foreign key pada tabel tugas
ALTER TABLE tugas ADD CONSTRAINT fk_mata_kuliah_id FOREIGN KEY (id_mata_kuliah) REFERENCES mata_kuliah(id_mata_kuliah);

-- Menambahkan foreign key pada tabel mata_kuliah
ALTER TABLE mata_kuliah ADD CONSTRAINT fk_dosen_id FOREIGN KEY (id_dosen) REFERENCES dosen(id_dosen);

CREATE TABLE mahasiswa_tugas (
    npm VARCHAR(10),
    id_tugas INT,
    status_tugas VARCHAR(50) NOT NULL,
    PRIMARY KEY (npm, id_tugas)
);

ALTER TABLE mahasiswa_tugas ADD CONSTRAINT fk_mahasiswa_npm FOREIGN KEY (npm) REFERENCES mahasiswa(id);
ALTER TABLE mahasiswa_tugas ADD CONSTRAINT fk_tugas_id FOREIGN KEY (id_tugas) REFERENCES tugas(id_tugas);
ALTER TABLE `tugas` ADD `link` VARCHAR(255) NOT NULL AFTER `nama_tugas`; 

INSERT INTO `dosen` (`id_dosen`, `nama_dosen`) VALUES 
('1', 'Dr. Eng. Agussalim, M.T..'), 
('2', 'Amalia Anjani Arifiyanti, S.Kom., M.Kom.'), 
('3', 'Arista Pratama S.Kom,, M.Kom.'), 
('4', 'Eristya Maya Safitri, S.Kom, M.Kom.'), 
('5', 'Seftin Fitri Ana Wati, S.Kom., M.Kom.'), 
('6', 'Dhian Satria Yudha Kartika, S.Kom, M.Kom.'); 

INSERT INTO `mata_kuliah` (`id_mata_kuliah`, `id_dosen`, `nama_mata_kuliah`) VALUES
 ('1', '1', 'Pemrograman Web'),
('2', '2', 'Data Warehouse dan OLAP'),
('3', '3', 'Etika Komputer'),
('4', '4', 'Keamanan Sistem Informasi'),
('5', '5', 'Administrasi Basis Data'),
('6', '4', 'Pengukuran Kinerja Teknologi Informasi'), 
('7', '2', 'Sistem Enterprise'),
 ('8', '6', 'Kepemimpinan');

 INSERT INTO `tugas` (`id_tugas`, `id_mata_kuliah`, `nama_tugas`, `link`, `deskripsi_tugas`, `deadline`) VALUES 
 (NULL, '1', 'TUGAS PRAKTEK 5', 'https://drive.google.com/drive/folders/1R_53xn-GLozZ2R1crZau9YghQwjfOVxc?usp=share_link', 'Penerapan module 5, Penerapan Lock Conflict dengan Command Prompt', '2023-05-14');
 (NULL, '2', 'INDIVASS06 - Penjadwalan ETL', 'https://ilmu.upnjatim.ac.id/mod/assign/view.php?id=191532', 'Modul 5 Penjadwalan ETL\r\nhttps://ilmu.upnjatim.ac.id/mod/resource/view.php?id=191531', '2023-05-14');

 INSERT INTO `mahasiswa_tugas` (`npm`, `id_tugas`, `status_tugas`) VALUES 
 ('21082010129', '1', 'Sudah Mengerjakan'),
 ('21082010129', '2', 'Belum Mengerjakan');