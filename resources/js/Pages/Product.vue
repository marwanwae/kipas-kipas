<script setup>
import { Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

const showForm = ref(false);
const isButtonShow = ref(false);
const isEditProduct = ref(false)
const products = ref([]);
const newProduct = ref({
    product_id: '',
    product_price: '',
    product_description: '',
    stock: '',
});


function showProduct(Product) {
    isButtonShow.value = true
    newProduct.value = Product;
}

function editProduct(Product) {
    isEditProduct.value = true
    newProduct.value = Product
}

async function fetchproducts() {
  try {
    const response = await axios.get('/api/product'); // Replace with your API endpoint
    console.log(response.data)
    if (response.status === 200) {
      products.value = response.data.response_data; // Populate the products ref with the retrieved data
    } else {
      alert('Failed to fetch products. Please try again.');
    }
  } catch (error) {
    console.error('Error fetching products:', error);
    alert('An error occurred while fetching products. Please try again later.');
  }
}

onMounted(() => {
  // Ambil data pelanggan ketika komponen dimuat
  fetchproducts();
});

async function addProduct() {
  try {
    const response = await axios.post('/api/product', newProduct.value); // Ganti dengan URL endpoint API Anda
    if (response.status === 200) {
      // Jika berhasil menambahkan pelanggan
      const newProductData = response.data.response_data;
      products.value.push(newProductData);
      // Reset form
      newProduct.value = {
        product_id: '',
        product_price: '',
        product_description: '',
        stock: '',
      };
      // Sembunyikan form
      showForm.value = false;
      alert('Product added successfully!');
    } else {
      alert('Failed to add Product. Please try again.');
    }
  } catch (error) {
    console.error('Error adding Product:', error);
    alert('An error occurred while adding the Product. Please try again later.');
  }
}

async function submitEditProduct() {
    try {
    const response = await axios.post('/api/product/'+ newProduct.value.product_id, newProduct.value); // Ganti dengan URL endpoint API Anda
    if (response.status === 200) {
      // Jika berhasil menambahkan pelanggan
      const editedProductData = response.data.response_data;
      const editedProductIndex = products.value.findIndex(Product => Product.Product_id === editedProductData.Product_id);

      if (editedProductIndex !== -1) {
        // Mengganti data pelanggan lama dengan data yang telah diedit
        products.value[editedProductIndex] = editedProductData;

        // Reset form
        newProduct.value = {
            product_id: '',
            product_price: '',
            product_description: '',
            stock: '',
        };

        // Sembunyikan form edit
        isEditProduct.value = false;

        alert('Product edited successfully!');
      } else {
        alert('Failed to find Product in the list. Please try again.');
      }
    } else {
      alert('Failed to edit Product. Please try again.');
    }
  } catch (error) {
    console.error('Error adding Product:', error);
    alert('An error occurred while adding the Product. Please try again later.');
  }
}
</script>

<template>
  <Head title="products" />

    <div class="max-w-7xl mx-auto p-6 lg:p-8">
        <div class="flex justify-center">
            <div class="py-12">
                <!-- Tampilkan form jika showForm bernilai true -->
                <form v-if="showForm" @submit.prevent="addProduct" class="my-8">
                    <div class="mb-4">
                    <label for="product_description" class="block text-gray-600">Product Description</label>
                    <input v-model="newProduct.product_description" type="text" id="product_description" name="product_description" required>
                    </div>
                    <div class="mb-4">
                    <label for="product_price" class="block text-gray-600">Price</label>
                    <input v-model="newProduct.product_price" type="number" id="product_price" name="product_price" required>
                    </div>
                    <div class="mb-4">
                    <label for="stock" class="block text-gray-600">Stock</label>
                    <input v-model="newProduct.stock" type="number" id="stock" name="stock" required>
                    </div>
                    <button type="submit" class="text-white bg-green-500 border border-transparent shadow-sm rounded hover:bg-blue-600 px-2 py-2">Add</button>
                </form>

                <button @click="showForm ? showForm = false : showForm = true" class="text-white bg-blue-500 border border-transparent shadow-sm rounded hover:bg-blue-600 px-2 py-2">Add Product</button>

                <table class='max-w-screen-xl mx-auto min-w-full divide-y divide-gray-100 shadow-sm border-gray-200 border'>
                    <thead class='px-3 py-2 font-semibold text-left bg-gray-100 border-b'>
                    <tr>
                        <th>Product ID</th>
                        <th>Product Description</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                    <tr v-for="(Product, index) in products" :key="index">
                        <td class="px-3 py-2 whitespace-no-wrap">{{ Product.product_id }}</td>
                        <td class="px-3 py-2 whitespace-no-wrap">{{ Product.product_description }}</td>
                        <td class="px-3 py-2 whitespace-no-wrap">Rp {{ Product.product_price }}</td>
                        <td class="px-3 py-2 whitespace-no-wrap">{{ Product.stock }}</td>
                        <td>
                        <button @click="showProduct(Product)" class="px-2">Show</button>
                        <button @click="editProduct(Product)" class="px-2">Edit</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div v-if="isButtonShow" class="fixed inset-0 flex items-center justify-center z-50">
        <div class="bg-white p-4 rounded-lg shadow-lg">
            <!-- Isi dari popup, misalnya informasi pelanggan -->
            <h2 class="text-lg font-semibold mb-2">{{ newProduct.product_description }}</h2>
            <p>Price: Rp {{ newProduct.product_price }}</p>
            <p>Stock: {{ newProduct.stock }}</p>

            <!-- Tombol untuk menutup popup -->
            <button @click="isButtonShow = false" class="text-gray-500 hover:text-gray-800">Close</button>
        </div>
    </div>

    <div v-if="isEditProduct" class="fixed inset-0 flex items-center justify-center z-50">
        <div class="bg-white p-4 rounded-lg shadow-lg">
            <!-- Isi dari popup, misalnya informasi pelanggan -->
            <form @submit.prevent="submitEditProduct" class="my-8">
                    <div class="mb-4">
                    <label for="product_description" class="block text-gray-600">Product Description</label>
                    <input v-model="newProduct.product_description" type="text" id="product_description" name="product_description" required>
                    </div>
                    <div class="mb-4">
                    <label for="product_price" class="block text-gray-600">Price</label>
                    <input v-model="newProduct.product_price" type="text" id="product_price" name="product_price" required>
                    </div>
                    <div class="mb-4">
                    <label for="stock" class="block text-gray-600">Stock</label>
                    <input v-model="newProduct.stock" type="text" id="stock" name="stock" required>
                    </div>
                    <button type="submit" class="text-white bg-green-500 border border-transparent shadow-sm rounded hover:bg-blue-600 px-2 py-2">Edit</button>
                </form>

            <!-- Tombol untuk menutup popup -->
            <button @click="isEditProduct = false" class="text-gray-500 hover:text-gray-800">Close</button>
        </div>
    </div>


</template>
