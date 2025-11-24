<template>
    <div class="home">
        <AppLayout>
            <main class="home__main">
                <div class="container">
                    <div class="home__content">
                        <h1 class="home__title">Добро пожаловать в Coffee Shop!</h1>

                        <div class="home__features">
                            <section class="feature">
                                <h3 class="feature__title">Свежий кофе</h3>
                                <p class="feature__desc">Ежедневно обжариваем зерна для идеального вкуса</p>
                            </section>

                            <section class="feature">
                                <h3 class="feature__title">Быстрая доставка</h3>
                                <p class="feature__desc">Доставляем за 30 минут в любую точку города</p>
                            </section>

                            <section class="feature">
                                <h3 class="feature__title">Лучшие цены</h3>
                                <p class="feature__desc">Качественный кофе по доступным ценам</p>
                            </section>
                        </div>

                        <div class="home__actions">
                            <template v-if="user">
                                <Link
                                    :href="route('user.profile')"
                                    class="home__btn home__btn--primary home__btn--large"
                                >
                                    Личный кабинет
                                </Link>
                            </template>

                            <template v-else>
                                <Link
                                    :href="route('register')"
                                    class="home__btn home__btn--primary home__btn--large"
                                >
                                    Начать покупки
                                </Link>
                            </template>
                        </div>
                    </div>
                </div>
            </main>
        </AppLayout>
    </div>
</template>

<script setup>
import {Link, usePage} from '@inertiajs/vue3'
import {ref, computed, onMounted} from 'vue'
import {route} from 'ziggy-js'
import AppLayout from "@/Components/AppLayout.vue"

const page = usePage()
const localUser = ref(null)

onMounted(() => {
    if (!page.props.auth.user) {
        const userFromStorage = localStorage.getItem('user')
        if (userFromStorage) {
            try {
                localUser.value = JSON.parse(userFromStorage)
            } catch (e) {
                localStorage.removeItem('user')
            }
        }
    }
})

// computed user: берем из props, если нет — из localStorage
const user = computed(() => page.props.auth.user || localUser.value)
</script>

<style lang="scss" scoped>
.home {
    min-height: 100vh;
    background-color: #f3f4f6; // заменил bg-gray-100

    &__nav {
        background-color: #fff;
        box-shadow: 0 1px 2px rgb(0 0 0 / 0.05);
        padding: 0.5rem 0;

        .container {
            max-width: 1120px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        &-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 4rem;
        }

        &__logo {
            h1 {
                font-size: 1.25rem; // text-xl
                font-weight: 700; // font-bold
                color: #1f2937; // text-gray-800
                margin: 0;
            }
        }

        &__menu {
            display: flex;
            align-items: center;
            gap: 1rem; // space-x-4
        }
    }

    &__link {
        color: #4b5563; // text-gray-600
        text-decoration: none;
        font-weight: 500;
        cursor: pointer;

        &:hover {
            color: #111827; // text-gray-900
        }
    }

    &__btn {
        background-color: #8b4513; // bg-coffee-600
        color: #fff;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem; // rounded
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        transition: background-color 0.3s ease;

        &--primary {
            background-color: #8b4513;

            &:hover {
                background-color: #654321; // bg-coffee-700
            }
        }

        &--large {
            padding: 0.75rem 2rem; // px-8 py-3
            font-size: 1rem;
        }
    }

    &__main {
        padding: 3rem 0; // py-12

        .container {
            max-width: 1120px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        &__content {
            background-color: #fff;
            border: 1px solid #e5e7eb; // border-gray-200
            border-radius: 0.5rem; // sm:rounded-lg
            box-shadow: 0 1px 2px rgb(0 0 0 / 0.05); // shadow-sm
            padding: 1.5rem; // p-6
        }

        &__title {
            font-size: 1.875rem; // text-3xl
            font-weight: 700; // font-bold
            color: #111827; // text-gray-900
            margin-bottom: 1.5rem; // mb-6
        }
    }

    &__features {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.5rem; // gap-6
        margin-bottom: 2rem; // mb-8

        @media (min-width: 768px) {
            grid-template-columns: repeat(3, 1fr);
        }
    }
}

.feature {
    background-color: #fef7f0; // bg-coffee-50
    padding: 1.5rem; // p-6
    border-radius: 0.5rem; // rounded-lg

    &__title {
        font-size: 1.125rem; // text-lg
        font-weight: 600; // font-semibold
        color: #5a3825; // text-coffee-800
        margin: 0 0 0.5rem 0;
    }

    &__desc {
        color: #8b4513; // text-coffee-600
        margin: 0;
    }
}

.home__actions {
    text-align: center;
}
</style>
