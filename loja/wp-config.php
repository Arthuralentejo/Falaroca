<?php
/**
 * As configurações básicas do WordPress
 *
 * O script de criação wp-config.php usa esse arquivo durante a instalação.
 * Você não precisa usar o site, você pode copiar este arquivo
 * para "wp-config.php" e preencher os valores.
 *
 * Este arquivo contém as seguintes configurações:
 *
 * * Configurações do MySQL
 * * Chaves secretas
 * * Prefixo do banco de dados
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/pt-br:Editando_wp-config.php
 *
 * @package WordPress
 */

// ** Configurações do MySQL - Você pode pegar estas informações com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define( 'DB_NAME', 'falaroca_loja' );

/** Usuário do banco de dados MySQL */
define( 'DB_USER', 'falaroca_loja' );

/** Senha do banco de dados MySQL */
define( 'DB_PASSWORD', 'D%xoA9xctkI^' );

/** Nome do host do MySQL */
define( 'DB_HOST', 'mysql592.lnxserversecure.com' );

/** Charset do banco de dados a ser usado na criação das tabelas. */
define( 'DB_CHARSET', 'utf8mb4' );

/** O tipo de Collate do banco de dados. Não altere isso se tiver dúvidas. */
define('DB_COLLATE', '');

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las
 * usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org
 * secret-key service}
 * Você pode alterá-las a qualquer momento para invalidar quaisquer
 * cookies existentes. Isto irá forçar todos os
 * usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'Vt8&Z}fe>vR;I}c+w?Cr3vMw>?*Kjy7j[}$shaiV`hjSJ!F^zXq_.[sNA&<K{&[T' );
define( 'SECURE_AUTH_KEY',  'Fkmi<w m~U_ ;5Oi!S?vmP%-cL%rg8MvV8^94)?R:3.hN<.=Fw+/&?uHH2WZZAM[' );
define( 'LOGGED_IN_KEY',    'si%#$^&Ohbzi=W+~J|FZxrtdCyQeBj9wq,b@K6J ])YMepa7FA9(Faeex,RMglM}' );
define( 'NONCE_KEY',        'LQ4(=1(8oy`}T$OoK7Au-d576`)X!uH3aT~4y`+B7@P;e5SWC#zGSo,G%7586kLI' );
define( 'AUTH_SALT',        '&=*ugRMzrk,|eZ/M2I*9DPm, Ga#91l+>+`qg)yDBh|J5wSeH?ph[W[FeWdgR8N5' );
define( 'SECURE_AUTH_SALT', '`KnNoNTJ[BtCO9jF73eo]#u@q3!gTVt#/2Z]lr)u1LQy$Y=<z)CHIkcg AM-_RX`' );
define( 'LOGGED_IN_SALT',   'P5lZ)#(S!$&{6h!_]2|aVeV7U3@gl/p#%o^+2F6h!Q[qt,6[X;7)Rb:DY4>l,+PV' );
define( 'NONCE_SALT',       'Tj.NU]+c/OXS41N{rV?=H5?&x;F4r*V$W. /A=|N<l@OJ42Qyez_5>$y/j[lQ&Fe' );

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der
 * um prefixo único para cada um. Somente números, letras e sublinhados!
 */
$table_prefix = 'falaroca_';

/**
 * Para desenvolvedores: Modo de debug do WordPress.
 *
 * Altere isto para true para ativar a exibição de avisos
 * durante o desenvolvimento. É altamente recomendável que os
 * desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 *
 * Para informações sobre outras constantes que podem ser utilizadas
 * para depuração, visite o Codex.
 *
 * @link https://codex.wordpress.org/pt-br:Depura%C3%A7%C3%A3o_no_WordPress
 */
define('WP_DEBUG', false);

/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Configura as variáveis e arquivos do WordPress. */
require_once(ABSPATH . 'wp-settings.php');
