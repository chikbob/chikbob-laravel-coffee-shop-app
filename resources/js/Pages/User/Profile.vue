<template>
    <div class="profile">
        <AppLayout>
            <main class="profile__main">
                <div class="profile__container">
                    <div class="profile__card">
                        <div class="profile__content">
                            <h1 class="profile__title">Личный кабинет</h1>

                            <section class="profile__info-block">
                                <h2 class="profile__info-title">Информация о пользователе</h2>
                                <div class="profile__info-list">
                                    <p><strong>Имя:</strong> {{ $page.props.auth.user.name }}</p>
                                    <p><strong>Email:</strong> {{ $page.props.auth.user.email }}</p>
                                    <p><strong>ID:</strong> {{ $page.props.auth.user.id }}</p>
                                </div>
                            </section>

                            <div class="profile__actions">
                                <button class="profile__btn">
                                    <h3 class="profile__btn-title">Мои заказы</h3>
                                    <p class="profile__btn-desc">История ваших заказов</p>
                                </button>

                                <button class="profile__btn">
                                    <h3 class="profile__btn-title">Настройки профиля</h3>
                                    <p class="profile__btn-desc">Изменить личные данные</p>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </AppLayout>
    </div>
</template>

<script setup>
import {Link, router} from '@inertiajs/vue3'
import AppLayout from "@/Components/AppLayout.vue";

const logout = () => {
    router.post('/api/logout', {}, {
        onFinish: () => router.visit('/')
    })
}
</script>

<style lang="scss" scoped>
$coffee-50: #fef7f0;
$coffee-600: #8b4513;
$coffee-700: #654321;
$coffee-800: #5a3825;
$text-gray-900: #1f2937;

.profile {
    min-height: 100vh;
    background-color: #f3f4f6; // примерно bg-gray-100

    &__main {
        padding: 3rem 0;
    }

    &__container {
        max-width: 1120px;
        margin: 0 auto;
        padding: 0 1rem;
    }

    &__card {
        background-color: #fff;
        overflow: hidden;
        box-shadow: 0 1px 3px rgb(0 0 0 / 0.1);
        border-radius: 0.5rem;
    }

    &__content {
        padding: 1.5rem 1.5rem;
        border-bottom: 1px solid #e5e7eb; // border-gray-200
    }

    &__title {
        font-size: 1.875rem; // text-3xl
        font-weight: 700;
        color: $text-gray-900;
        margin-bottom: 1.5rem;
    }

    &__info-block {
        background-color: $coffee-50;
        padding: 1.5rem;
        border-radius: 0.5rem;
        margin-bottom: 1.5rem;
    }

    &__info-title {
        font-size: 1.25rem; // text-xl
        font-weight: 600;
        color: $coffee-800;
        margin-bottom: 1rem;
    }

    &__info-list {
        p {
            margin-bottom: 0.5rem;
            strong {
                font-weight: 600;
            }
        }
    }

    &__actions {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1rem;

        @media(min-width: 768px) {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    &__btn {
        background-color: $coffee-600;
        color: #fff;
        padding: 1rem;
        border: 0;
        border-radius: 0.5rem;
        text-align: left;
        cursor: pointer;
        transition: background-color 0.3s ease;

        &:hover {
            background-color: $coffee-700;
        }

        &-title {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        &-desc {
            font-size: 0.875rem;
            opacity: 0.9;
        }
    }
}
</style>
