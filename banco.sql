
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `pedido` (
  `id` smallint(8) NOT NULL,
  `id_transacao` text CHARACTER SET latin1 NOT NULL,
  `status` text CHARACTER SET latin1 NOT NULL,
  `valor` text CHARACTER SET latin1 NOT NULL,
  `desconto` text CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `pedido`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `pedido`
  MODIFY `id` smallint(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=273;
COMMIT;