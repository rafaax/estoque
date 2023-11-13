<aside class="menu-sidebar d-none d-lg-block">
            <div class="logo">
                <a href="index">
                    <img src="images/icon/Logo-Vetorian-Horizontal-Color.png" alt="vetorian" />
                </a>
            </div>
            <div class="menu-sidebar__content js-scrollbar1">
                <nav class="navbar-sidebar">
                    <ul class="list-unstyled navbar__list">
                        <li class="index">
                            <a class="js-arrow" href="index">
                                <i class="fas fa-globe"></i>Tela inicial</a>
                        </li>
                        <li class="compras">
                            <a href="compras">
                                <i class="fas fa-shopping-bag"></i> Compras
                            </a>
                        </li>
                        <li class="recebidos">
                            <a href="recebidos">
                                <i class="fas fa-truck"></i>Recebimento
                            </a>
                        </li>
                        <li class="estoque">
                            <a href="estoque">
                                <i class="fas fa-box"></i> Estoque
                            </a>
                        </li>
                        <li class="retirada">
                            <a href="retirada">
                                <i class="fas fa-sign-in-alt"></i> Retirada
                            </a>
                        </li>
                        <li class="categorias">
                            <a href="categorias">
                                <i class="fas fa-folder"></i>Categorias</a>
                        </li>
                        <li class="fornecedores">
                            <a href="fornecedores">
                                <i class="fas fa-building"></i>Fornecedores</a>
                        </li>
                        <li class="solicitantes">
                            <a href="solicitantes">
                                <i class="fas fa-user"></i>Solicitantes</a>
                        </li>
                         <li class="pagamentos">
                            <a href="pagamento">
                                <i class="fas fa-dollar-sign"></i>Formas de Pagamento</a>
                        </li>
        
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-desktop"></i>UI Elements</a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="htmls/button.html">Button</a>
                                </li>
                                <li>
                                    <a href="htmls/badge.html">Badges</a>
                                </li>
                                <li>
                                    <a href="htmls/tab.html">Tabs</a>
                                </li>
                                <li>
                                    <a href="htmls/card.html">Cards</a>
                                </li>
                                <li>
                                    <a href="htmls/alert.html">Alerts</a>
                                </li>
                                <li>
                                    <a href="htmls/progress-bar.html">Progress Bars</a>
                                </li>
                                <li>
                                    <a href="htmls/modal.html">Modals</a>
                                </li>
                                <li>
                                    <a href="htmls/switch.html">Switchs</a>
                                </li>
                                <li>
                                    <a href="htmls/grid.html">Grids</a>
                                </li>
                                <li>
                                    <a href="htmls/fontawesome.html">Fontawesome Icon</a>
                                </li>
                                <li>
                                    <a href="htmls/typo.html">Typography</a>
                                </li>
                                <li class="has-sub">
                                    <a class="js-arrow" href="#">Pages</a>
                                    <ul class="list-unstyled navbar__sub-list js-sub-list">
                                        <li>
                                            <a href="htmls/login.html">Login</a>
                                        </li>
                                        <li>
                                            <a href="htmls/register.html">Register</a>
                                        </li>
                                        <li>
                                            <a href="htmls/forget-pass.html">Forget Password</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="has-sub">
                                    <a class="js-arrow" href="#">Outros</a>
                                    <ul class="list-unstyled navbar__sub-list js-sub-list">
                                        <li>
                                            <a href="htmls/chart.html">
                                                <i class="fas fa-chart-bar"></i>Charts</a>
                                        </li>
                                        <li>
                                            <a href="htmls/table.html">
                                                <i class="fas fa-table"></i>Tables</a>
                                        </li>
                                        <li>
                                            <a href="htmls/form.html">
                                                <i class="far fa-check-square"></i>Forms</a>
                                        </li>
                                        <li>
                                            <a href="htmls/calendar.html">
                                                <i class="fas fa-calendar-alt"></i>Calendar</a>
                                        </li>
                                        <li>
                                            <a href="htmls/map.html">
                                                <i class="fas fa-map-marker-alt"></i>Maps</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>


        <script>
            var currentPath = window.location.pathname;
            var liIndex = document.getElementsByClassName('index')[0];
            var liCategorias = document.getElementsByClassName('categorias')[0];
            var liSolicitantes = document.getElementsByClassName('solicitantes')[0];
            var liFornecedores = document.getElementsByClassName('fornecedores')[0];
            var liPagamentos = document.getElementsByClassName('pagamentos')[0];
            var liCompras = document.getElementsByClassName('compras')[0];
            var liRecebidos = document.getElementsByClassName('recebidos')[0];
            var liEstoque = document.getElementsByClassName('estoque')[0];
            var liRetirada = document.getElementsByClassName('retirada')[0];

            // console.log(currentPath);
            
            if(currentPath === '/estoque_git/index' || currentPath === '/estoque_git/index.php' || currentPath === '/estoque_git/'){
                liIndex.classList.add('active');
            }else if(currentPath === '/estoque_git/categorias' || currentPath === '/estoque_git/categorias.php' ){
                liCategorias.classList.add('active');
            }else if(currentPath === '/estoque_git/solicitantes' || currentPath === '/estoque_git/solicitantes.php'){
                liSolicitantes.classList.add('active');
            }else if(currentPath === '/estoque_git/fornecedores' || currentPath === '/estoque_git/fornecedores.php'){
                liFornecedores.classList.add('active');
            }else if(currentPath === '/estoque_git/pagamento' || currentPath === '/estoque_git/pagamento.php'){
                liPagamentos.classList.add('active');
            }else if(currentPath === '/estoque_git/compras' || currentPath === '/estoque_git/compras.php'){
                liCompras.classList.add('active');
            }else if(currentPath === '/estoque_git/recebidos' || currentPath === '/estoque_git/recebidos.php'){
                liRecebidos.classList.add('active');
            }else if(currentPath === '/estoque_git/estoque' || currentPath === '/estoque_git/estoque.php'){
                liEstoque.classList.add('active');
            }else if(currentPath === '/estoque_git/retirada' || currentPath === '/estoque_git/retirada.php'){
                liRetirada.classList.add('active');
            }
        </script>