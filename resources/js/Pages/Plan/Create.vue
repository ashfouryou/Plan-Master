<template>
    <Head title="Plans" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ plan ? 'Edit Plan' : 'Create Plan' }}
            </h2>
        </template>
        
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
                <div class="space-y-6 sm:px-6 lg:px-0 lg:col-span-12">
                    <form @submit.prevent="submitForm">
                        <div class="shadow sm:rounded-md sm:overflow-hidden">
                            <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                                <div>
                                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                                        Plan Information
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-500">
                                        Use this form to {{ plan ? 'edit' : 'create' }} a plan.
                                    </p>
                                </div>

                                <div class="grid grid-cols-6 gap-6">
                                    <!-- Plan Name -->
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="name" class="block text-sm font-medium text-gray-700">
                                            Plan Name
                                        </label>
                                        <input
                                            type="text"
                                            id="name"
                                            v-model="form.name"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                            :class="{ 'border-red-300 text-red-900 focus:ring-red-500 focus:border-red-500': form.errors.name }"
                                        />
                                        <p v-if="form.errors.name" class="mt-1 text-sm text-red-500">
                                            {{ form.errors.name }}
                                        </p>
                                    </div>

                                    <!-- Plan Price -->
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
                                            :class="{ 'border-red-300 text-red-900 focus:ring-red-500 focus:border-red-500': form.errors.price }"
                                        />
                                        <p v-if="form.errors.price" class="mt-1 text-sm text-red-500">
                                            {{ form.errors.price }}
                                        </p>
                                    </div>

                                    <!-- Plan Description --> 
                                    <div class="col-span-6">
                                        <label for="description" class="block text-sm font-medium text-gray-700">
                                            Description
                                        </label>
                                        <textarea
                                            id="description"
                                            v-model="form.description"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                            :class="{ 'border-red-300 text-red-900 focus:ring-red-500 focus:border-red-500': form.errors.description }"
                                        ></textarea>
                                        <p v-if="form.errors.description" class="mt-1 text-sm text-red-500">
                                            {{ form.errors.description }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                <Link
                                    :href="route('plan.index')"
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

<script>
import { Head, Link, useForm } from "@inertiajs/vue3";
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

export default {
    components: {
        Head,
        Link,
        AuthenticatedLayout,
    },
    props: {
        plan: Object, // Passed from server if editing
    },
    setup(props) {
        const form = useForm({
            name: props.plan?.name || '',
            price: props.plan?.price || '',
            description: props.plan?.description || '',
            status: props.status?.status|| '1',
        });

        function submitForm() {
            if (props.plan) {
                // Update existing plan
                form.put(route("plan.update", props.plan.id), {
                    preserveScroll: true,
                });
            } else {
                // Create new plan
                form.post(route("plan.store"), {
                    preserveScroll: true,
                });
            }
        }

        return {
            form,
            submitForm,
        };
    }
};
</script>

<style scoped>
</style>
