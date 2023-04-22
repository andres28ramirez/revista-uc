<div class="d-sm-flex align-items-center justify-content-between mb-4">
    
    <h1 class="h3 mb-0 text-gray-800">
        @if(request()->is('*/dashboard')) Panel Dashboard @endif

        <!-- Ediciones -->
        @if(request()->is('*/edicion')) Todas las Ediciones @endif
        @if(request()->is('*/edicion/create')) Panel Creación de Ediciones @endif

        <!-- Conocimientos -->
        @if(request()->is('*/edicion/conocimiento')) Panel de Control - Areas de Conocimiento @endif
        
        <!-- Articulos -->
        @if(request()->is('*/articulos')) Panel de Artículos @endif
        @if(request()->is('*/articulos/todos')) Panel de Artículos Completos @endif
        @if(request()->is('*/articulos/view/*')) Visual de Artículo Seleccionado @endif
        @if(request()->is('*/articulos/create')) Panel Creación de Artículos @endif
        @if(request()->is('*/articulos/edit/*')) Panel Modificación de Artículos @endif
    </h1>

    <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
</div>