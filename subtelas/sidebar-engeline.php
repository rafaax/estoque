<aside class="menu-sidebar d-none d-lg-block">
            <div class="logo">
                <a href="index">
                    <img src="../images/icon/Logo-Vetorian-Horizontal-Color.png" alt="vetorian" />
                </a>
            </div>
            <div class="menu-sidebar__content js-scrollbar1">
                <nav class="navbar-sidebar">
                    <ul class="list-unstyled navbar__list">
                        <li class="index">
                            <a class="js-arrow" href="../index">
                                <i class="fas fa-globe"></i>Tela inicial</a>
                        </li>
                        <li class="compras">
                            <a href="compras">
                                <i class="fas fa-shopping-bag"></i> Compras
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>


        <script>
            var currentPath = window.location.pathname;
            var liIndex = document.getElementsByClassName('index')[0];
            var liCompras = document.getElementsByClassName('compras')[0];

            // console.log(currentPath);
            
            if(currentPath === '/estoque_git/index' || currentPath === '/estoque_git/index.php' || currentPath === '/estoque_git/'){
                liIndex.classList.add('active');
            }else if(currentPath === '/estoque_git/engeline/compras' || currentPath === '/estoque_git/engeline/compras.php'){
                liCompras.classList.add('active');
            }
        </script>