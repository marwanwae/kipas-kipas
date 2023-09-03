<script setup>
import { Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

const showForm = ref(false);
const isButtonShow = ref(false);
const isEditorder = ref(false)
const orders = ref([]);
const neworder = ref({
    order_id: '',
    customer_id: '',
    customer_name: '',
    amount: '',
    quality: '',
    product_id: '',
    order_date: '',
});

async function fetchorders() {
  try {
    const response = await axios.get('/api/order'); // Replace with your API endpoint
    console.log(response.data)
    if (response.status === 200) {
      orders.value = response.data.response_data; // Populate the orders ref with the retrieved data
    } else {
      alert(response.data.response_message);
    }
  } catch (error) {
    console.error('Error fetching orders:', error);
    alert(response.data.response_message);
  }
}

onMounted(() => {
  // Ambil data pelanggan ketika komponen dimuat
  fetchorders();
});

async function addorder() {
  try {
    const response = await axios.post('/api/order', neworder.value); // Ganti dengan URL endpoint API Anda
    if (response.status === 200) {
      // Jika berhasil menambahkan pelanggan
      const neworderData = response.data.response_data;
      console.info(neworderData);
      orders.value.push(neworderData);
      // Reset form
      neworder.value = {
        order_id: '',
        customer_id: '',
        customer_name: '',
        amount: '',
        quality: '',
        product_id: '',
        order_date: '',
      };
      // Sembunyikan form
      showForm.value = false;
      alert(response.data.response_message);
    } else {
      alert(response.data.responseMessage);
    }
  } catch (error) {
    console.error('Error adding order:', error);
    alert('An error occurred while adding the order. Please try again later.');
  }
}

</script>

<template>
  <Head title="Orders" />

    <div class="max-w-7xl mx-auto p-6 lg:p-8">
        <div class="flex justify-center">
            <div class="py-12">
                <!-- Tampilkan form jika showForm bernilai true -->
                <form v-if="showForm" @submit.prevent="addorder" class="my-8">
                    <div class="mb-4">
                    <label for="customer_id" class="block text-gray-600">Customer Id</label>
                    <input v-model="neworder.customer_id" type="number" id="customer_id" name="customer_id" required>
                    </div>
                    <div class="mb-4">
                    <label for="quality" class="block text-gray-600">Quality</label>
                    <input v-model="neworder.quality" type="number" id="quality" name="quality" required>
                    </div>
                    <div class="mb-4">
                    <label for="product_id" class="block text-gray-600">product Id</label>
                    <input v-model="neworder.product_id" type="number" id="product_id" name="product_id" required>
                    </div>
                    <div class="mb-4">
                    <label for="order_date" class="block text-gray-600">Order Date</label>
                    <input v-model="neworder.order_date" type="datetime-local" id="order_date" name="order_date" required>
                    </div>
                    <button type="submit" class="text-white bg-green-500 border border-transparent shadow-sm rounded hover:bg-blue-600 px-2 py-2">Add</button>
                </form>

                <button @click="showForm ? showForm = false : showForm = true" class="text-white bg-blue-500 border border-transparent shadow-sm rounded hover:bg-blue-600 px-2 py-2">Add order</button>

                <table class='max-w-screen-xl mx-auto min-w-full divide-y divide-gray-100 shadow-sm border-gray-200 border'>
                    <thead class='px-3 py-2 font-semibold text-left bg-gray-100 border-b'>
                    <tr>
                        <th>order ID</th>
                        <th>customer id</th>
                        <th>customer name</th>
                        <th>amount</th>
                        <th>quality</th>
                        <th>product id</th>
                        <th>order date</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                    <tr v-for="(order, index) in orders" :key="index">
                        <td class="px-3 py-2 whitespace-no-wrap">{{ order.order_id }}</td>
                        <td class="px-3 py-2 whitespace-no-wrap">{{ order.customer_id }}</td>
                        <td class="px-3 py-2 whitespace-no-wrap">{{ order.customer_name }}</td>
                        <td class="px-3 py-2 whitespace-no-wrap">Rp {{ order.amount }}</td>
                        <td class="px-3 py-2 whitespace-no-wrap">{{ order.quality }}</td>
                        <td class="px-3 py-2 whitespace-no-wrap">{{ order.product_id }}</td>
                        <td class="px-3 py-2 whitespace-no-wrap">{{ order.order_date }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


</template>
