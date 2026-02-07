import { reactive, computed, onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';

// État global partagé entre tous les composants
const state = reactive({
    items: [],
});

export function useCart() {
    const { props } = usePage(); // Pour récupérer l'utilisateur et sa remise
    
    const total = () => {
        const subtotal = state.items.reduce((acc, item) => acc + (item.price * item.quantity), 0);
        const discount = props.auth.user?.is_pro ? 0.15 : 0;
        return (subtotal * (1 - discount)).toFixed(2);
    };
    // Charger le panier au démarrage
    const loadCart = () => {
        const saved = localStorage.getItem('quincaillerie_cart');
        if (saved) {
            state.items = JSON.parse(saved);
        }
    };

    const saveCart = () => {
        localStorage.setItem('quincaillerie_cart', JSON.stringify(state.items));
    };

    const addToCart = (product, customQuantity = 1) => {
        const qty = parseFloat(customQuantity);
        const existing = state.items.find(i => i.id === product.id);
        
        if (existing) {
            existing.quantity += qty;
        } else {
            state.items.push({
                id: product.id,
                name: product.name,
                price: product.price_cents / 100,
                // ON FORCE LE STOCKAGE DE L'UNITÉ ICI
                unit: product.unit || 'unit', 
                quantity: qty,
                image: product.image
            });
        }
        saveCart();
    };

    const removeFromCart = (id) => {
        state.items = state.items.filter(i => i.id !== id);
        saveCart();
    };

    const clearCart = () => {
        state.items = [];
        localStorage.removeItem('quincaillerie_cart');
    };

    const count = () => state.items.reduce((acc, item) => acc + item.quantity, 0);
    
    // const total = () => state.items.reduce((acc, item) => acc + (item.price * item.quantity), 0).toFixed(2);

    return {
        state,
        addToCart,
        removeFromCart,
        clearCart,
        loadCart,
        count,
        total
    };
}