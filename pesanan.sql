

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


CREATE TABLE IF NOT EXISTS `tabel_makanan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_makanan` varchar(32) NOT NULL,
  `harga` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `tanggal_pesanan` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1459347720 ;


INSERT INTO `tabel_makanan` (`id`, `nama_makanan`, `harga`, `quantity`, `tanggal_pesanan`) VALUES
(1459346526, 'wagyu', 1000000, 6, '2021-10-20'),
(1459347719, 'Jus', 50000, 7, '2021-08-02');

