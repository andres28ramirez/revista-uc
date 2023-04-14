<div class="d-sm-flex align-items-center justify-content-between mb-4">
    
    <h1 class="h3 mb-0 text-gray-800">
        @if(request()->is('*/inicio')) Dashboard @endif

        <!-- Ediciones -->
        @if(request()->is('*/edicion')) Todas las Ediciones @endif
        @if(request()->is('*/edicion/create')) Panel Creación de Ediciones @endif
    </h1>

    <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
</div>