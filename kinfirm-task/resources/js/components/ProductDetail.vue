<template>
  <div class="product-detail-container">
    <div class="product-detail-content bg-cover">
      <header class="header">
        Product Details
        <button @click="$emit('close')" class="close-button">X</button>
      </header>
      <form @submit.prevent="updateProduct" class="space-y-4">
        <div>
          <label for="sku" class="label">SKU</label>
          <input 
            id="sku" 
            type="text" 
            v-model="product.sku" 
            class="input-field" 
            placeholder="SKU" 
            required 
          />
        </div>
        <div>
          <label for="description" class="label">Description</label>
          <textarea 
            id="description" 
            v-model="product.description" 
            class="input-field" 
            placeholder="Product Description" 
            required 
          ></textarea>
        </div>
        <div>
          <label for="size" class="label">Size</label>
          <input 
            id="size" 
            type="text" 
            v-model="product.size" 
            class="input-field" 
            placeholder="Product Size" 
          />
        </div>
        <div>
          <label for="photo" class="label">Photo URL</label>
          <input 
            id="photo" 
            type="text" 
            v-model="product.photo" 
            class="input-field" 
            placeholder="Product Photo URL" 
          />
        </div>
        <div>
          <label for="updated_at" class="label">Last Updated</label>
          <input 
            id="updated_at" 
            type="text" 
            v-model="formattedDate" 
            class="input-field" 
            disabled 
          />
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    product: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      formattedDate: new Date(this.product.updated_at).toLocaleDateString()
    };
  },
   
};
</script>

<style scoped>
.product-detail-container {
  display: flex;
  justify-content: center;
  align-items: center;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  font-family: 'Segoe UI', 'Helvetica Neue', sans-serif;
}

.product-detail-content {
  background-color: rgba(255, 255, 255, 0.95);
  padding: 20px;
  border-radius: 8px;
  width: 100%;
  max-width: 600px;
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
  position: relative;
}

.header {
  padding: 1rem;
  background-color: #25aae1;
  color: #ffffff;
  text-align: center;
  font-size: 1.5rem;
  font-weight: bold;
  border-radius: 8px 8px 0 0;
  margin-bottom: 20px;
  position: relative;
}

.close-button {
  position: absolute;
  right: 10px;
  top: 10px;
  background: #e53e3e;
  color: #ffffff;
  border: none;
  border-radius: 50%;
  width: 24px;
  height: 24px;
  font-size: 1.25rem;
  cursor: pointer;
}

.label {
  display: block;
  font-size: 1.25rem;
  font-weight: medium;
  color: #000000;
  margin-bottom: 0.25rem;
}

.input-field {
  width: 100%;
  padding: 0.75rem;
  font-size: 1.25rem;
  border: 1px solid #cbd5e0;
  border-radius: 0.375rem;
  margin-bottom: 1rem;
}

.submit-button {
  width: 100%;
  font-size: 1.5rem;
  font-weight: 600;
  color: #fff;
  cursor: pointer;
  display: block;
  margin: auto;
  height: 3.5rem;
  text-align: center;
  border: none;
  background-size: 300% 100%;
  border-radius: 2rem;
  transition: all 0.4s ease-in-out;
}

.submit-button-hover:hover {
  background-position: 100% 0;
  transition: all 0.4s ease-in-out;
}

.submit-button-hover:focus {
  outline: none;
}

.submit-button-hover.bn18 {
  background-image: linear-gradient(
    to right,
    #25aae1,
    #1d8ecf
  );
}
</style>
