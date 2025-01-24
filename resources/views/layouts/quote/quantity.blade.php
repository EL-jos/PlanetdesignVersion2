
<input value="{{ $item->quantity }}"
       hx-post="{{ route('cart.update.quantity', ['cartItem' => $item->id]) }}"
       hx-trigger="input blur"
       hx-headers='{"X-CSRF-TOKEN": "{{ csrf_token() }}"}'
       type="number" name="quantity" id="quantityInput" class="quantity-input" min="1">


<script>
    document.addEventListener("DOMContentLoaded", function() {
        const quantityInputs = document.querySelectorAll(".quantity-input");

        quantityInputs.forEach(input => {
            input.addEventListener("blur", function() {
                modifyQuantity(input);
            });
            input.addEventListener("input", function() {
                modifyQuantity(input);
            });
        });
    });

    function modifyQuantity(input) {
        const newQuantity = input.value;
        const hxRequest = new HxRequest({
            url: input.getAttribute("hx-get"),
            params: { quantity: newQuantity }
        });
        hxRequest.trigger();
    }

    @if(request()->attributes->has('htmx'))
        @switch($code)
            @case(0)
                Swal.fire({
                    icon: 'success',
                    title: 'Valide',
                    text: "{!! $message !!}"
                });
                @break
            @case(1)
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: "{!! $message !!}"
                });
                @break
        @endswitch
    @endif
</script>
