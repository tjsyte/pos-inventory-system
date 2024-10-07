document.addEventListener('alpine:init', function () {

    Alpine.data('products', function(products) {
        let _this = this
        return {
            products,
            payment: 0,
            carts: [],

            init() {
                _this.$refs.change.innerText = '--';
            },

            validate: function(e) {
                let change = this.calculateChange();
                if (change < 0 || this.carts.length == 0) {
                    e.preventDefault();
                }
            },

            calculateChange: function() {
                let change = this.payment - this.totalPrice;
                if (change < 0) {
                    alert('Not enough payment');
                } else {
                    _this.$refs.change.innerText = change + ' PHP';
                }
                return change;
            },

            get totalPrice() {
                return this.carts.reduce((acm, cart) => {
                    return acm + (cart.quantity * cart.product.price);
                }, 0);
            },

            subtractQuantity: function(cart) {
                cart.quantity--;
                if (cart.quantity < 1) {
                    this.carts = this.carts.filter(_cart => _cart.product.id != cart.product.id);
                }
            },

            addQuantity: function(cart){
                if (cart.quantity < cart.product.quantity) {
                    cart.quantity++;
                }
            },

            addToCart: function(id) {
                let product = products.find(product => product.id == id);
                let cart = this.carts.find(cart => cart.product.id == id);

                if (!product || product.quantity < 1) {
                    return alert('Out of stock or invalid product');
                }

                if (cart) {
                    if (cart.quantity < product.quantity) {
                        cart.quantity++;
                    }
                } else {
                    this.carts.push({
                        product: product,
                        quantity: 1
                    });
                }
            }
        };
    });

});
