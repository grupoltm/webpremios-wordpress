<?php 
    $userinfo = ltm_getUserinfo();
	$balance = ltm_getBalance();
?>
<p id="greeting">
    Olá <strong id="username"><?= $userinfo['name']; ?></strong>,
    você tem <strong id="total-points"><?= $balance; ?></strong> 
    <span class="currency-name"><?= get_option('currecy_name'); ?></span>!
</p>