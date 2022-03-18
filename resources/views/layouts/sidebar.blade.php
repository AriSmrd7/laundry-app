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
      <a class="nav-link" href="{{url('admin/order-transaksi')}}">
        <i class="menu-icon typcn typcn-th-large-outline"></i>
        <span class="menu-title">Data Transaksi</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{url('admin/jasa')}}">
        <i class="menu-icon typcn typcn-th-large-outline"></i>
        <span class="menu-title">Data Paket</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{url('admin/pewangi')}}">
        <i class="menu-icon typcn typcn-th-large-outline"></i>
        <span class="menu-title">Data Pewangi</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{url('admin/customer')}}">
        <i class="menu-icon typcn typcn-th-large-outline"></i>
        <span class="menu-title">Data Pelanggan</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{url('admin/member')}}">
        <i class="menu-icon typcn typcn-th-large-outline"></i>
        <span class="menu-title">Data Member</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{url('admin/petugas')}}">
        <i class="menu-icon typcn typcn-th-large-outline"></i>
        <span class="menu-title">Data Kasir</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{url('admin/laporan')}}">
        <i class="menu-icon typcn typcn-th-large-outline"></i>
        <span class="menu-title">Laporan</span>
      </a>
    </li>
    @endif

    @if(Auth::User()->hasRole('ROLE_KASIR'))
    <li class="nav-item">
      <a class="nav-link" href="{{url('kasir')}}">
        <i class="menu-icon typcn typcn-document-text"></i>
        <span class="menu-title">Home</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{url('kasir/order')}}">
        <i class="menu-icon typcn typcn-shopping-bag"></i>
        <span class="menu-title">Buat Order Baru</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{url('kasir/transaksi')}}">
        <i class="menu-icon typcn typcn-th-large-outline"></i>
        <span class="menu-title">Transaksi Order</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{url('kasir/pelanggan')}}">
        <i class="menu-icon typcn typcn-th-large-outline"></i>
        <span class="menu-title">Data Pelanggan</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{url('kasir/member-kasir')}}">
        <i class="menu-icon typcn typcn-th-large-outline"></i>
        <span class="menu-title">Data Member</span>
      </a>
    </li>
   @endif
  </ul>
</nav>