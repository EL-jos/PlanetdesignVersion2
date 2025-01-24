<!-- SELECT2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    // Fonction pour mettre à jour les articles en fonction des filtres sélectionnés
    function updateFilteredArticles() {
        //const selectedSubcategoryId = $('.el-filter-select').data('subcategory-id');
        const selectedColors = $('#color_id').val();
        const selectedMaterials = $('#material_id').val();
        const selectedAvailabilities = $('#availability_id').val();

        $.ajax({
            url: "{{ route('filter.articles') }}",
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: {
                //subcategory_id: selectedSubcategoryId,
                color_ids: selectedColors,
                material_ids: selectedMaterials,
                availability_ids: selectedAvailabilities,
                @if(isset($category))
                category_id: {{ $category->id }},
                @elseif(isset($subcategory))
                subcategory_id: {{ $subcategory->id }}
                @else
                statut: @if($title === 'Nouvel arrivage') 1 @elseif($title === 'Déstockage') 5 @endif
                @endif
            },
            success: function(response) {
                $('.el-grid-articles').html(response);
            },
            error: function(xhr, textStatus, errorThrown) {
                console.error(errorThrown);
            }
        });
    }

    // Écouter les événements de changement de valeur sur les <select> de filtre
    $('.el-filter-select').on('change', function() {
        updateFilteredArticles();
    });
</script>

<script>
    function initializeOwlCarousel(element) {
        $(element).owlCarousel({
            items: 3,
            loop: true,
            nav: true,
            dots: false,
            autoplay: true,
            autoplaySpeed: 1000,
            smartSpeed: 1500,
            autoplayHoverPause: true,
            margin: 0,
            center: true,
        });


        $(".el-article").each(function () {

            var $article = $(this);

            $article.find(".el-content .owl-carousel img").off("click").on("click", function () {
                let newSrc = $(this).attr("data-src");
                let id = $(this).attr("data-id");
                let model = $(this).attr("data-model");
                $article.find(".el-boxImg img").attr("src", newSrc);

                $article.find(".el-add-catalogue").attr("href", `/add/${id}/${model}/catalog`);
                $article.find(".el-add-devis").attr("href", `/add/${id}/${model}/cart`);

                console.log(id, $article.find(".el-add-catalogue").attr("href"))

            }).css('cursor', 'pointer');

        });
    }
    function reinitializeAllOwlCarousels() {
        const owlCarousels = document.querySelectorAll("#el-articles .owl-carousel");
        owlCarousels.forEach(owlCarousel => {
            $(owlCarousel).trigger('destroy.owl.carousel'); // Détruire l'instance existante
            initializeOwlCarousel(owlCarousel); // Réinitialiser
        });
    }
    // Appel initial pour initialiser les sliders
    reinitializeAllOwlCarousels();
    document.addEventListener("htmx:afterOnLoad", function () {
        // Réinitialisation après chaque chargement htmx
        reinitializeAllOwlCarousels();
    });
</script>

<script>
    const initializedElements = new Set();

    function initializeTomSelect(element) {
        if (!initializedElements.has(element)) {
            new TomSelect(element, {plugins: {remove_button: {title: 'Supprimer'}}});
            initializedElements.add(element);
        }
    }

    function initializeAllTomSelects() {
        const selectsMultiple = document.querySelectorAll("select[multiple]");
        selectsMultiple.forEach(select => {
            initializeTomSelect(select);
        });
    }

    // Initialisation lors du chargement initial de la page
    initializeAllTomSelects();

    document.addEventListener("htmx:afterOnLoad", function () {
        // Initialisation après chaque chargement htmx
        console.log("chargement fini")
        initializeAllTomSelects();
    });
</script>

<script>
    const initializedSelectColorElements = new Set();

    function initializeSelect2(element) {
        if (!initializedSelectColorElements.has(element)) {
            $(element).select2({
                placeholder: `${element.name === 'color_id' ? 'Couleur' : 'Taille'} ?`,
                width: '100%',
                //allowClear: true
            });
            initializedSelectColorElements.add(element);
        }
    }

    function initializeAllSelect2() {
        const selects = document.querySelectorAll("select.color_id");
        selects.forEach(select => {
            initializeSelect2(select);
        });
    }

    // Initialisation lors du chargement initial de la page
    initializeAllSelect2();

    document.addEventListener("htmx:afterOnLoad", function () {
        // Initialisation après chaque chargement htmx
        initializeAllSelect2();
    });
</script>
