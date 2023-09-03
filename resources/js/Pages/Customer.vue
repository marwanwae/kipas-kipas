<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

const showForm = ref(false);
const isButtonShow = ref(false);
const isEditCustomer = ref(false)
const customers = ref([]);
const newCustomer = ref({
  customer_name: '',
  address: '',
  phone: '',
});


function showCustomer(customer) {
    isButtonShow.value = true
    newCustomer.value = customer;
}

function editCustomer(customer) {
    isEditCustomer.value = true
    newCustomer.value = customer
}

async function fetchCustomers() {
  try {
    const response = await axios.get('/api/customer'); // Replace with your API endpoint
    console.log(response.data)
    if (response.status === 200) {
      customers.value = response.data.response_data; // Populate the customers ref with the retrieved data
    } else {
      alert('Failed to fetch customers. Please try again.');
    }
  } catch (error) {
    console.error('Error fetching customers:', error);
    alert('An error occurred while fetching customers. Please try again later.');
  }
}

onMounted(() => {
  // Ambil data pelanggan ketika komponen dimuat
  fetchCustomers();
});

async function addCustomer() {
  try {
    const response = await axios.post('/api/customer', newCustomer.value); // Ganti dengan URL endpoint API Anda
    if (response.status === 200) {
      // Jika berhasil menambahkan pelanggan
      const newCustomerData = response.data.response_data;
      customers.value.push(newCustomerData);
      // Reset form
      newCustomer.value = {
        customer_id: '',
        customer_name: '',
        address: '',
        phone: '',
      };
      // Sembunyikan form
      showForm.value = false;
      alert('Customer added successfully!');
    } else {
      alert('Failed to add customer. Please try again.');
    }
  } catch (error) {
    console.error('Error adding customer:', error);
    alert('An error occurred while adding the customer. Please try again later.');
  }
}

async function submitEditCustomer() {
    try {
    const response = await axios.post('/api/customer/'+ newCustomer.value.customer_id, newCustomer.value); // Ganti dengan URL endpoint API Anda
    if (response.status === 200) {
      // Jika berhasil menambahkan pelanggan
      const editedCustomerData = response.data.response_data;
      const editedCustomerIndex = customers.value.findIndex(customer => customer.customer_id === editedCustomerData.customer_id);

      if (editedCustomerIndex !== -1) {
        // Mengganti data pelanggan lama dengan data yang telah diedit
        customers.value[editedCustomerIndex] = editedCustomerData;

        // Reset form
        newCustomer.value = {
          customer_name: '',
          address: '',
          phone: '',
        };

        // Sembunyikan form edit
        isEditCustomer.value = false;

        alert('Customer edited successfully!');
      } else {
        alert('Failed to find customer in the list. Please try again.');
      }
    } else {
      alert('Failed to edit customer. Please try again.');
    }
  } catch (error) {
    console.error('Error adding customer:', error);
    alert('An error occurred while adding the customer. Please try again later.');
  }
}
</script>

<template>
  <Head title="Customers" />

    <div class="max-w-7xl mx-auto p-6 lg:p-8">
        <div class="flex justify-center">
            <div class="py-12">
                <!-- Tampilkan form jika showForm bernilai true -->
                <form v-if="showForm" @submit.prevent="addCustomer" class="my-8">
                    <div class="mb-4">
                    <label for="customer_name" class="block text-gray-600">Customer Name</label>
                    <input v-model="newCustomer.customer_name" type="text" id="customer_name" name="customer_name" required>
                    </div>
                    <div class="mb-4">
                    <label for="address" class="block text-gray-600">Address</label>
                    <input v-model="newCustomer.address" type="text" id="address" name="address" required>
                    </div>
                    <div class="mb-4">
                    <label for="phone" class="block text-gray-600">Phone</label>
                    <input v-model="newCustomer.phone" type="text" id="phone" name="phone" required>
                    </div>
                    <button type="submit" class="text-white bg-green-500 border border-transparent shadow-sm rounded hover:bg-blue-600 px-2 py-2">Add</button>
                </form>

                <button @click="showForm ? showForm = false : showForm = true" class="text-white bg-blue-500 border border-transparent shadow-sm rounded hover:bg-blue-600 px-2 py-2">Add Customer</button>

                <table class='max-w-screen-xl mx-auto min-w-full divide-y divide-gray-100 shadow-sm border-gray-200 border'>
                    <thead class='px-3 py-2 font-semibold text-left bg-gray-100 border-b'>
                    <tr>
                        <th>Customer ID</th>
                        <th>Customer Name</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                    <tr v-for="(customer, index) in customers" :key="index">
                        <td class="px-3 py-2 whitespace-no-wrap">{{ customer.customer_id }}</td>
                        <td class="px-3 py-2 whitespace-no-wrap">{{ customer.customer_name }}</td>
                        <td class="px-3 py-2 whitespace-no-wrap">{{ customer.address }}</td>
                        <td class="px-3 py-2 whitespace-no-wrap">{{ customer.phone }}</td>
                        <td>
                        <button @click="showCustomer(customer)" class="px-2">Show</button>
                        <button @click="editCustomer(customer)" class="px-2">Edit</button>
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
            <h2 class="text-lg font-semibold mb-2">{{ newCustomer.customer_name }}</h2>
            <p>Address: {{ newCustomer.address }}</p>
            <p>Phone: {{ newCustomer.phone }}</p>

            <!-- Tombol untuk menutup popup -->
            <button @click="isButtonShow = false" class="text-gray-500 hover:text-gray-800">Close</button>
        </div>
    </div>

    <div v-if="isEditCustomer" class="fixed inset-0 flex items-center justify-center z-50">
        <div class="bg-white p-4 rounded-lg shadow-lg">
            <!-- Isi dari popup, misalnya informasi pelanggan -->
            <form @submit.prevent="submitEditCustomer" class="my-8">
                    <div class="mb-4">
                    <label for="customer_name" class="block text-gray-600">Customer Name</label>
                    <input v-model="newCustomer.customer_name" type="text" id="customer_name" name="customer_name" required>
                    </div>
                    <div class="mb-4">
                    <label for="address" class="block text-gray-600">Address</label>
                    <input v-model="newCustomer.address" type="text" id="address" name="address" required>
                    </div>
                    <div class="mb-4">
                    <label for="phone" class="block text-gray-600">Phone</label>
                    <input v-model="newCustomer.phone" type="text" id="phone" name="phone" required>
                    </div>
                    <button type="submit" class="text-white bg-green-500 border border-transparent shadow-sm rounded hover:bg-blue-600 px-2 py-2">Edit</button>
                </form>

            <!-- Tombol untuk menutup popup -->
            <button @click="isEditCustomer = false" class="text-gray-500 hover:text-gray-800">Close</button>
        </div>
    </div>


</template>
