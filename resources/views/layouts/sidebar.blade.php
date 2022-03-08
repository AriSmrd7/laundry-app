<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item nav-category">Main Menu</li>

    @if(Auth::User()->hasRole('ROLE_ADMIN'))
    <li class="nav-item active">
      <a class="nav-link" href="{{url('admin')}}">
        <i class="menu-icon typcn typcn-document-text"></i>
        <span class="menu-title">Home</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{url('admin/pesanan')}}">
        <i class="menu-icon typcn typcn-shopping-bag"></i>
        <span class="menu-title">Data Pesanan</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{url('admin/transaksi')}}">
        <i class="menu-icon typcn typcn-th-large-outline"></i>
        <span class="menu-title">Data Transaksi</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{url('admin/jasa')}}">
        <i class="menu-icon typcn typcn-th-large-outline"></i>
        <span class="menu-title">Data Jasa</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{url('admin/pewangi')}}">
        <i class="menu-icon typcn typcn-th-large-outline"></i>
        <span class="menu-title">Data Pewangi</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{url('admin/pelanggan')}}">
        <i class="menu-icon typcn typcn-th-large-outline"></i>
        <span class="menu-title">Data Pelanggan</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{url('admin/petugas')}}">
        <i class="menu-icon typcn typcn-th-large-outline"></i>
        <span class="menu-title">Data Petugas</span>
      </a>
    </li>
    @endif

    @if(Auth::User()->hasRole('ROLE_KASIR'))
    <li class="nav-item">
      <a class="nav-link" href="index.html">
        <i class="menu-icon typcn typcn-document-text"></i>
        <span class="menu-title">Home</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="pages/forms/basic_elements.html">
        <i class="menu-icon typcn typcn-shopping-bag"></i>
        <span class="menu-title">Order Pesanan</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="pages/charts/chartjs.html">
        <i class="menu-icon typcn typcn-th-large-outline"></i>
        <span class="menu-title">Transaksi</span>
      </a>
    </li>
   @endif
  </ul>
</nav>