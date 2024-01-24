<template>
    <div class="page">
        <header class="navbar navbar-expand-sm navbar-light d-print-none">
            <div class="container-xl">
                <h1
                    class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3"
                >
                    <a href="/demos">
                        <h1>Todo App</h1>
                    </a>
                </h1>

                <div class="navbar-nav flex-row order-md-last">
                    <div class="nav-item dropdown">
                    <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu" aria-expanded="false">
                        <span class="avatar avatar-sm" style="background-image: url(./static/avatars/000m.jpg)"></span>
                        <div class="d-none d-xl-block ps-2">
                        <div>{{ $page.props.auth.user.name }}</div>
                        <div class="mt-1 small text-secondary">UI Designer</div>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <Link href="/auth/logout" method="post" class="dropdown-item" as="button">Logout</Link>
                    </div>
                    </div>
                </div>
            </div>
        </header>
        <div class="page-wrapper">
            <div class="page-body">
                <div class="container-xl">
                    <slot></slot>
                </div>
            </div>
        </div>
    </div>
</template>


<script setup>
import { Head } from '@inertiajs/vue3'
import {Link} from '@inertiajs/vue3';
</script>