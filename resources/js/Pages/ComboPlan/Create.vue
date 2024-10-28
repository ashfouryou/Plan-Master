<template>
    <AuthenticatedLayout>
        <Head :title="comboPlan ? 'Edit Combo Plan' : 'Create Combo Plan'" />

        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
                <div class="space-y-6 sm:px-6 lg:px-0 lg:col-span-12">
                    <form @submit.prevent="submit">
                        <div class="shadow sm:rounded-md sm:overflow-hidden">
                            <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                                <div>
                                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                                        Combo Plan Information
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-500">
                                        Use this form to {{ comboPlan ? 'edit' : 'create' }} a combo plan.
                                    </p>
                                </div>

                                <div class="grid grid-cols-6 gap-6">
                                    <!-- Combo Plan Name -->
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="name" class="block text-sm font-medium text-gray-700">
                                            Combo Plan Name
                                        </label>
                                        <input
                                            type="text"
                                            id="name"
                                            v-model="form.name"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                            :class="{ 'border-red-500 text-red-900 focus:ring-red-500 focus:border-red-500': form.errors.name }"
                                        />
                                        <p v-if="form.errors.name" class="mt-1 text-sm text-red-500">
                                            {{ form.errors.name }}
                                        </p>
                                    </div>

                                    <!-- Combo Plan Price -->
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="price" class="block text-sm font-medium text-gray-700">
                                            Price
                                        </label>
                                        <input
                                            step=".01"
                                            type="number"
                                            id="price"
                                            v-model="form.price"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                            :class="{ 'border-red-500 text-red-900 focus:ring-red-500 focus:border-red-500': form.errors.price }"
                                        />
                                        <p v-if="form.errors.price" class="mt-1 text-sm text-red-500">
                                            {{ form.errors.price }}
                                        </p>
                                    </div>

                                    <!-- Combo Plan Description --> 
                                    <div class="col-span-6">
                                        <label for="description" class="block text-sm font-medium text-gray-700">
                                            Description
                                        </label>
                                        <textarea
                                            id="description"
                                            v-model="form.description"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                            :class="{ 'border-red-500 text-red-900 focus:ring-red-500 focus:border-red-500': form.errors.description }"
                                        ></textarea>
                                        <p v-if="form.errors.description" class="mt-1 text-sm text-red-500">
                                            {{ form.errors.description }}
                                        </p>
                                    </div>

                                    <!-- Plan Selection  -->
            <div class="mb-4" v-if="plans.length > 0">
                <label class="block text-sm font-medium text-gray-700 mb-1">Select Plans</label>
                <div class="grid grid-cols-2 gap-4">
                    <div
                        v-for="plan in plans"
                        :key="plan.id"
                        class="flex items-center"
                    >
                        <input
                            type="checkbox"
                            :value="plan.id"
                            v-model="form.selectedPlans"
                            class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                        />
                        <label class="ml-2 text-sm text-gray-700">
                            {{ plan.name }} - ${{ plan.price }}
                        </label>
                    </div>
                </div>
            </div>
            
            <div v-else>
                <p class="text-gray-500">No plans available.</p>
            </div>
                                </div>
                            </div>

                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                <Link
                                    :href="route('combo-plans.index')"
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-4"
                                >
                                    Cancel
                                </Link>
                                <button
                                    type="submit"
                                    class="bg-indigo-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                >
                                    Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

// Define props
const props = defineProps({
    plans: {
        type: Array,
        default: () => [],
    },
    comboPlan: {
        type: Object,
        default: null,
    },
});

const form = useForm({
    name: props.comboPlan ? props.comboPlan.name : "",
    description: props.comboPlan ? props.comboPlan.description : "",
    price: props.comboPlan ? props.comboPlan.price : "",
    selectedPlans: props.comboPlan && props.comboPlan.plans ? props.comboPlan.plans.map(plan => plan.id) : []
});

const submit = () => {
    const routeName = props.comboPlan ? 'combo-plans.update' : 'combo-plans.store';
    const options = {
        onStart: () => form.processing = true,
        onFinish: () => form.processing = false,
        preserveScroll: true
    };

    if (props.comboPlan) {
        form.put(route(routeName, props.comboPlan.id), options);
    } else {
        form.post(route(routeName), options);
    }
};
</script>

<style scoped>
</style>
