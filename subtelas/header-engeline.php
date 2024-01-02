<?php require_once '../get_dados.php';?>

<header class="header-desktop">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="header-wrap">
                <form class="form-header">
                </form>
                <div class="header-button">
                    <div class="account-wrap">
                        <div class="account-item clearfix js-item-menu">
                            <div class="image">
                                <img src="../<?=$fotoSession?>" />
                            </div>
                            <div class="content">
                                <a class="js-acc-btn" href="#"><?php echo "$nomeSession $sobrenomeSession";?></a>
                            </div>
                            <div class="account-dropdown js-dropdown">
                                <div class="info clearfix">
                                    <div class="image">
                                        <a href="#">
                                            <img src="../<?=$fotoSession?>" />
                                        </a>
                                    </div>
                                    <div class="content">
                                        <h5 class="name">
                                            <a href="#"><?php echo "$nomeSession $sobrenomeSession";?></a>
                                        </h5>
                                        <span class="email"><?=$emailSession?></span>
                                    </div>
                                </div>
                                <div class="account-dropdown__body">
                                    <div class="account-dropdown__item">
                                        <a href="../account.php">
                                            <i class="zmdi zmdi-account"></i>Conta</a>
                                    </div>
                                    <div class="account-dropdown__item">
                                        <a href="../compras.php">
                                            <i class="zmdi zmdi-account"></i>Trocar para sistema vetorian</a>
                                    </div>
                                </div>
                                <div class="account-dropdown__footer">
                                    <a href="../validacao/logout.php">
                                        <i class="zmdi zmdi-power"></i>Sair da conta</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>