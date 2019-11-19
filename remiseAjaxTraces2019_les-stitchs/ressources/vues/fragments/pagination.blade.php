    <!-- Si on est pas sur la première page et s'il y a plus d'une page -->
    @if ($numeroPage > 0)
        <a href= "{!! $urlPagination . "&page=" . 0  !!}#contenu" class="pagination__doubleArrow">
            <svg class="pagination__doubleArrowIcon">
                <use xlink:href="#doubleArrowLeft" />
            </svg>
        </a>
    @else
        <svg class="pagination__doubleArrowIcon pagination__doubleArrowIcon--inactif">
            <use xlink:href="#doubleArrowLeft" />
        </svg> <!-- Bouton premier inactif -->
    @endif

    @if ($numeroPage > 0)
        <a href="{!! $urlPagination . "&page=" . (htmlspecialchars($numeroPage) - 1) !!}#contenu" class="pagination__arrow">        
            <svg class="pagination__arrowIcon">
                <use xlink:href="#arrowLeft" />
            </svg>
        </a>
    @else
        <svg class="pagination__arrowIcon pagination__doubleArrowIcon--inactif">
            <use xlink:href="#arrowLeft" />
        </svg>
    @endif
    
    @if($numeroPage < $nombreTotalPages - 2)
        <!-- Page active -->
        <span class="pagination__pageActive">
            {{ ($numeroPage + 1) }}
        </span> 

        <!-- Page suivante -->
        <a href="{!! $urlPagination . "&page=" . (htmlspecialchars($numeroPage) + 1)  !!}#contenu" class="pagination__page">
            {{ ($numeroPage + 2) }}
        </a>
        ... 
        <!-- Avant dernière page -->
        <a href="{!! $urlPagination . "&page=" . (htmlspecialchars($nombreTotalPages) - 1)  !!}#contenu" class="pagination__page">
            {{ $nombreTotalPages }}
        </a>
        <!-- Affiche la dernière page -->
            <a href="{!! $urlPagination . "&page=" . (htmlspecialchars($nombreTotalPages))  !!}#contenu" class="pagination__page">
            {{ $nombreTotalPages + 1 }}
        </a>
        @if($numeroPage == $nombreTotalPages - 2)
        <!-- Page active -->
        <span class="pagination__pageActive">
            {{ ($numeroPage + 1) }}
        </span> 

        <!-- Page suivante -->
        <a href="{!! $urlPagination . "&page=" . (htmlspecialchars($numeroPage) + 1)  !!}#contenu" class="pagination__page">
            {{ ($numeroPage + 2) }}
        </a>
        @endif
    @else
        <!-- Page active -->
        <span class="pagination__pageActive">
            {{ ($numeroPage + 1) }}
        </span> 

    @endif





    <!-- Si on est pas sur la dernière page et s'il y a plus d'une page -->
    @if ($numeroPage < $nombreTotalPages)
        <a href="{!! $urlPagination . "&page=" . (htmlspecialchars($numeroPage) + 1)  !!}#contenu" class="pagination__arrow">
            <svg class="pagination__arrowIcon">
                <use xlink:href="#arrowRight" />
            </svg>
        </a>
    @else
        <svg class="pagination__arrowIcon pagination__doubleArrowIcon--inactif">
            <use xlink:href="#arrowRight" />
        </svg>
    @endif

    @if ($numeroPage < $nombreTotalPages)
        <a href="{!! $urlPagination . "&page=" . htmlspecialchars($nombreTotalPages) !!}#contenu" class="pagination__doubleArrow">
            <svg class="pagination__doubleArrowIcon">
                <use xlink:href="#doubleArrowRight" />
            </svg>
        </a>
    @else
        <svg class="pagination__doubleArrowIcon pagination__doubleArrowIcon--inactif">
            <use xlink:href="#doubleArrowRight" />
        </svg>
    @endif



