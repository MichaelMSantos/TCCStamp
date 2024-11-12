<aside id="sidebar" class="">
    <div class="d-flex">
        <button class="toggle-btn" type="button">
            {{-- <i class="">
                <img src="/images/sidebar/menu.svg" alt="" class="menu">
            </i> --}}
            <i class="bi bi-arrow-left"></i>
        </button>
        <div class="sidebar-logo" style="position: absolute">
            <a href="#">StampControl</a>
        </div>
    </div>
    <ul class="sidebar-nav">
        <li class="sidebar-item">
            <a href="{{ route('dashboard') }}" class="sidebar-link home">
                <img src="{{ asset('/images/sidebar/home.svg') }}" alt="">
                <span>Início</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="#" class="sidebar-link collapsed has-dropdown estoque" data-bs-toggle="collapse"
                data-bs-target="#auth" aria-expanded="false" aria-controls="auth">
                <img class="loge" src="{{ asset('/images/sidebar/system-uicons_box.svg') }}" alt="false">
                <span>Estoque</span>
            </a>
            <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                <li class="sidebar-item">
                    <a href="{{ route('camiseta.index') }}" class="sidebar-link camisetas">Camisetas</a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('tinta.index') }}" class="sidebar-link tintas">Tintas</a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('tecido.index') }}" class="sidebar-link tecidos">Tecidos</a>
                </li>
            </ul>
        </li>
        <li class="sidebar-item">
            <a href="{{ route('monitoramento.index') }}" class="sidebar-link financeiro">
                <img src="{{ asset('/images/sidebar/material-symbols_finance-mode-rounded.svg') }}" alt="">
                <span>Monitoramento</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="{{ route('pouco_estoque') }}" class="sidebar-link pouco-estoque">
                <img src="{{ asset('/images/sidebar/healthicons_stock-out-outline.svg') }}" alt="">
                <span>Pouco esotque</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="{{ route('funcionarios.index') }}" class="sidebar-link administradores">
                <img src="{{ asset('/images/sidebar/clarity_administrator-line.svg') }}" alt="">
                <span>Administradores</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="{{ route('fornecedor.index') }}" class="sidebar-link fornecedores">
                <img src="{{ asset('/images/sidebar/fornecedores.svg') }}" alt="">
                <span>Forncedores</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="{{ route('envio.index') }}" class="sidebar-link envio">
                <img src="{{ asset('/images/sidebar/envelope.svg') }}" alt="">
                <span>Envio</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="{{ route('consulta.index') }}" class="sidebar-link consultar">
                <img src="{{ asset('/images/sidebar/search-box.svg') }}" alt="">
                <span>Consultar</span>
            </a>
        </li>
    </ul>
    </li>
    <li class="sidebar-item">
        <a href="{{ route('profile.show') }}" class="sidebar-link">
            <img src="{{ asset('/images/sidebar/person.svg') }}" alt="" class="person-img truncate">
            <span>
                {{ Auth::user()->name }}
            </span>
        </a>
    </li>
    <li class="sidebar-item backup">
        <a href="#" class="sidebar-link">
            <img src="{{ asset('/images/sidebar/backup.svg') }}" alt="" class="backup-img">
            <span>Backup</span>
        </a>
    </li>
    <div class="divisor">
        <hr>
    </div>
    </ul>
    <div class="sidebar-footer">
        <a href="{{ route('user.logout') }}" class="sidebar-link">
            <img src="{{ asset('/images/sidebar/logout.svg') }}" alt="" class="logout-img">
            <span>log out</span>
        </a>
    </div>
</aside>
