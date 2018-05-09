<?php
/**
 * The template for displaying the header
 *
 * @package WordPress
 * @subpackage wp-ltm
 * @since LTM Cloud Loyalty 1.0
 */
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>LTM - Cloud Loyalty</title>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <link rel="shortcut icon" href="<?= get_template_directory_uri(); ?>/assets/img/ltm/favicon.ico" type="image/x-icon" />
        <link rel="icon" href="<?= get_template_directory_uri(); ?>/assets/img/favicon.ico" type="image/x-icon" />
        <link href="<?= get_template_directory_uri(); ?>/style.css" rel="stylesheet" />
		<link href="<?= get_template_directory_uri(); ?>/assets/css/login.css" rel="stylesheet" />

        <link rel="apple-touch-icon" sizes="180x180" href="<?= get_template_directory_uri(); ?>/assets/img/ltm/apple-touch-icon.png" />
		<link rel="icon" type="image/png" sizes="32x32" href="<?= get_template_directory_uri(); ?>/assets/img/ltm/favicon-32x32.png" />
		<link rel="icon" type="image/png" sizes="16x16" href="<?= get_template_directory_uri(); ?>/assets/img/ltm/favicon-16x16.png" />

		<link rel="mask-icon" href="<?= get_template_directory_uri(); ?>/assets/img/ltm/safari-pinned-tab.svg" color="#5bbad5" />

    <?php wp_head(); ?>
    </head>
    <body>
        <main class="container-fliud">
            