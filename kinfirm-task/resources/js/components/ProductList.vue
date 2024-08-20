<template>
  <div class="product-list-container">
    <div class="product-list-content bg-cover">
      <header class="header">
        Product Management
      </header>
      <div v-if="products.length">
        <div v-for="product in products" :key="product.id" class="product-card">
          <img :src="product.photo" alt="Product Image" class="product-image" />
          <h2 class="product-title">{{ product.sku || 'SKU not available' }}</h2>
          <p class="product-description">{{ product.description }}</p>
          <p class="product-size">Size: {{ product.size || 'N/A' }}</p>
          <p class="product-updated">Last Updated: {{ new Date(product.updated_at).toLocaleDateString() }}</p>
          <button @click="viewProduct(product)" class="view-button">
            View Details
          </button>
        </div>
      </div>
      <div v-else>
        <p class="no-products">No products available.</p>
      </div>
      <ProductDetail v-if="selectedProduct" :product="selectedProduct" @close="selectedProduct = null" />
    </div>
  </div>
  <!-- Pagination Controls -->
  <div class="pagination-controls" v-if="pagination && pagination.last_page > 1">
    <button 
      @click="fetchProducts(currentPage - 1)" 
      :disabled="currentPage <= 1"
    >
      Previous
    </button>
    <span>Page {{ pagination.current_page }} of {{ pagination.last_page }}</span>
    <button 
      @click="fetchProducts(currentPage + 1)" 
      :disabled="currentPage >= pagination.last_page"
    >
      Next
    </button>
  </div>
</template>

<script>
import axios from 'axios';
import ProductDetail from './ProductDetail.vue';
import { mapGetters, mapActions } from 'vuex';

export default {
  components: { ProductDetail },
  data() {
    return {
      products: [],
      pagination: {
        current_page: 1,
        last_page: 1,
      },
      currentPage: 1,
      selectedProduct: null,
    };
  },
  computed: {
    ...mapGetters(['isAuthenticated']),
  },
  methods: {
    ...mapActions(['logout']),
    async fetchProducts(page = 1) {
      page = Number(page);
      if (isNaN(page) || page < 1) {
        page = 1;
      }

      if (!this.isAuthenticated) {
        return; 
      }

      try {
        const token = this.$store.state.token;
        const response = await axios.get(`/api/products?page=${page}`, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });
        // Assign products and pagination data from API response
        this.products = response.data.data;
        this.pagination = {
          current_page: response.data.meta.current_page,
          last_page: response.data.meta.last_page,
        };
        this.currentPage = this.pagination.current_page;
      } catch (error) {
        console.error('Error fetching products:', error);
      }
    },
    async logout() {
      try {
        await this.$store.dispatch('logout');
        this.$router.push('/login');
      } catch (error) {
        console.error('Error logging out:', error);
      }
    },
    viewProduct(product) {
      this.selectedProduct = product;
    },
  },
  mounted() {
    if (this.isAuthenticated) {
      this.fetchProducts();
    }
  }
}
</script>

<style scoped>
.product-list-container {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  background-color: #f3f4f6;
  background-size: cover;
  background-position: center;
  font-family: 'Segoe UI', 'Helvetica Neue', sans-serif;
}

.product-list-content {
  background-color: rgba(255, 255, 255, 0.95);
  padding: 20px;
  border-radius: 8px;
  width: 100%;
  max-width: 800px;
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
  position: relative;
}

.header {
  padding: 1rem;
  background-color: #25aae1;
  color: #ffffff;
  text-align: center;
  font-size: 2rem;
  font-weight: bold;
  border-radius: 8px 8px 0 0;
  margin-bottom: 20px;
}

.product-card {
  background: #ffffff;
  border-radius: 8px;
  padding: 20px;
  margin-bottom: 20px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.product-image {
  width: 150px; /* Reduce the width */
  height: auto; /* Maintain aspect ratio */
  border-radius: 8px;
  margin-bottom: 10px;
}

.product-title {
  font-size: 1.5rem;
  font-weight: bold;
}

.product-description, .product-size, .product-updated {
  margin: 10px 0;
}

.product-updated {
  color: #555;
}

.view-button {
  background-color: #25aae1;
  color: #ffffff;
  border: none;
  padding: 10px 20px;
  border-radius: 8px;
  cursor: pointer;
  font-size: 1rem;
}

.view-button:hover {
  background-color: #1d8ecf;
}

.no-products {
  text-align: center;
  font-size: 1.25rem;
}

/* Pagination Controls */
.pagination-controls {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: 20px;
}

.pagination-controls button {
  padding: 10px 20px;
  margin: 0 5px;
  background-color: #25aae1;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.pagination-controls button:disabled {
  background-color: #ccc;
  cursor: not-allowed;
}
</style>
