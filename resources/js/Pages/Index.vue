<script setup>

import AppLayout from "@/Layouts/AppLayout.vue";
import { router, useForm, usePage } from '@inertiajs/vue3'
import { Head } from '@inertiajs/vue3'
import { onMounted } from "vue";
import { ref } from "vue";

const debounce = (func, timeout = 1000) => {
    let timeoutId;
    return function() {
        const context = this;
        const args = arguments;
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => {
            func.apply(context, args);
        }, timeout);
    };
}

const props = defineProps({
    todos: {
        type: Object,
        default: () => ({}),
    },
});

const searchTerm = ref(usePage().props.query.search_term || '');

const pagination = ref({
    current_page: props.todos.current_page || 1,
    per_page: props.todos.per_page,
    total_page: props.todos.last_page,
    total_data: props.todos.total
});

const formData = useForm({
    todo_name: null,
    is_completed: null
});

const handleGet = () => {
    router.get('/', { search_term: searchTerm.value, page: pagination.value.current_page }, { preserveState: true });
}

const handleStore = () => {
    formData.post('/todos', {
        onSuccess: () => formData.reset()
    })
}

const handleComplete = (id) => {
    formData.is_completed = 1;

    formData.put('/todos/' + id, {
        onSuccess: () => formData.reset()
    })
}

const handleModal = (id) => {
    document.getElementById('delete-modal-confirm').addEventListener('click', () => {
        handleDelete(id);
    })
}

const handleDelete = (id) => {
    // formData.delete('/todos/' + id)

    router.delete('/todos/' + id, { preserveState: true });
}

const handleSearch = debounce(() => {
    pagination.value.current_page = 1;

    handleGet();
});

const handlePaginate = (page) => {
    pagination.value.current_page = Number(page);

    handleGet();
}

</script>

<template>
    <Head>
        <title>Todos</title>
    </Head>
    <AppLayout>
        <!-- Modal -->
        <div class="modal modal-blur fade" id="delete-modal" tabindex="-1" role="dialog" aria-modal="true" >
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-status bg-danger"></div>
                <div class="modal-body text-center py-4">
                    <!-- Download SVG icon from http://tabler-icons.io/i/alert-triangle -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 9v4"></path><path d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z"></path><path d="M12 16h.01"></path></svg>
                    <h3>Are you sure?</h3>
                    <div class="text-secondary">Do you really want to remove ? What you've done cannot be undone.</div>
                </div>
                <div class="modal-footer">
                    <div class="w-100">
                    <div class="row">
                        <div class="col"><a class="btn w-100" data-bs-dismiss="modal">
                            Cancel
                        </a></div>
                        <div class="col"><a id="delete-modal-confirm" class="btn btn-danger w-100" data-bs-dismiss="modal">
                            Delete
                        </a></div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
        </div>

        <form action="" @submit.prevent="handleStore">
            <div class="row" style="margin-bottom: 1rem">
                <div class="col-6">
                    <input type="text" :class="formData.errors.todo_name ? 'form-control is-invalid' : 'form-control'" v-model="formData.todo_name"
                        name="todo_name" placeholder="Buy groceries">
                        <div class="invalid-feedback" v-if="formData.errors.todo_name">{{ formData.errors.todo_name }}</div>
                </div>
                <div class="col-2">
                    <button class="btn btn-primary" type="submit">
                        Create Todo
                    </button>
                </div>
            </div>
        </form>
        <div class="card">
            <!-- <div class="input-icon m-2">
                <input type="text" v-model="searchTerm" class="form-control" placeholder="Search…" @input="handleSearch()">
                <span class="input-icon-addon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path><path d="M21 21l-6 -6"></path></svg>
                </span>
            </div> -->
            <div class="card-body border-bottom py-3">
                    <div class="d-flex">
                      <div class="ms-auto text-secondary">
                        Search:
                        <div class="ms-2 d-inline-block">
                            <input type="text" v-model="searchTerm" class="form-control form-control-sm" @input="handleSearch()">
                        </div>
                      </div>
                    </div>
                  </div>
            <div class="table-responsive">
                <table class="table table-vcenter card-table">
                    <thead>
                        <tr>
                            <th width="10%">#</th>
                            <th>Todo Name</th>
                            <th>Status</th>
                            <th width="10%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <template v-for="(todo, idx) in todos.data">
                        <tr>
                            <td>{{ idx + 1 }}</td>
                            <td>{{ todo.todo_name }}</td>
                            <td>
                                <template v-if="todo.is_completed">
                                    <span class="badge bg-success me-1"></span> Completed
                                </template>
                                <template v-else>
                                    <span class="badge bg-warning me-1"></span> Ongoing
                                </template>
                            </td>
                            <td>
                                <div class="btn-list flex-nowrap">
                                    <button type="button" class="btn btn-icon btn-sm btn-green" @click="handleComplete(todo.id)" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Mark as completed">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                                    </button>
                                    <button type="button" class="btn btn-icon btn-sm btn-red" data-bs-target="#delete-modal" data-bs-toggle="modal" @click="handleModal(todo.id)" data-bs-placement="bottom" title="Tooltip on bottom">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>
                    </tbody>
                </table>
            </div>
            <div class="card-footer d-flex align-items-center">
                <p class="m-0 text-secondary">Showing <span>{{ todos.from || 0 }}</span> to <span>{{ todos.to || 0 }}</span> of <span>{{ todos.total || 0 }}</span> entries per page</p>
                <ul class="pagination m-0 ms-auto">
                    <template v-for="link in todos.links.slice(1, -1)">
                        <li :class="link.active ? 'page-item active' : 'page-item'"><a class="page-link cursor-pointer" @click="handlePaginate(link.label)">{{ link.label }}</a></li>
                    </template>
                </ul>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>


</style>
