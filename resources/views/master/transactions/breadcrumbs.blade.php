<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{!! market()->url('transactions') !!}">Transactions</a></li>
            {!! Market::breadcrumbs($location) !!}
        <li class="active"></li>
    </ol>
</nav>