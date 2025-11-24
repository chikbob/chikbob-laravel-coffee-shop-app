<template>
    <div class="app-layout">
        <header class="app-header">
            <div class="container">
                <div class="header__row">
                    <div class="header__logo">
                        <Link :href="route('home')">
                            <h1>☕ Coffee Shop</h1>
                        </Link>
                    </div>

                    <nav class="header__nav">
                        <template v-if="$page.props.auth.user">
                            <Link :href="route('user.profile')" class="header__link">
                                {{ $page.props.auth.user.name }}
                            </Link>
                            <Link
                                :href="route('logout')"
                                method="post"
                                as="button"
                                class="header__btn header__btn--primary"
                            >
                                Выйти
                            </Link>
                        </template>

                        <template v-else>
                            <Link :href="route('login')" class="header__link">Войти</Link>
                            <Link :href="route('register')" class="header__btn header__btn--primary">
                                Регистрация
                            </Link>
                        </template>
                    </nav>
                </div>
            </div>
        </header>

        <main class="app-main">
            <slot/>
        </main>

        <footer class="app-footer">
            <div class="container">
                <p>© 2025 Coffee Shop. Все права защищены.</p>
            </div>
        </footer>
    </div>
</template>

<script setup>
import {Link, usePage} from '@inertiajs/vue3'
import {route} from 'ziggy-js'

const page = usePage()
</script>

<style lang="scss" scoped>
.app-layout {
    min-height: 100vh;
    display: flex;
    flex-direction: column;

    .container {
        max-width: 1120px;
        margin: 0 auto;
        padding: 0 1rem;
    }

    .app-header {
        background: #fff;
        box-shadow: 0 1px 2px rgb(0 0 0 / 0.05);
        padding: 0.5rem 0;

        .header__row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 4rem;
        }

        .header__logo a {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1f2937;
            margin: 0;
            text-decoration: none;
        }

        .header__nav {
            display: flex;
            gap: 1rem;
            align-items: center;

            &__link {
                color: #4b5563;
                font-weight: 500;
                text-decoration: none;
                cursor: pointer;

                &:hover {
                    color: #111827;
                }
            }

            .header__link {
                color: #4b5563;
                font-weight: 500;
                text-decoration: none;
                cursor: pointer;

                &:hover {
                    color: #111827;
                }
            }

            .header__btn {
                background-color: #8b4513;
                color: #fff;
                padding: 0.5rem 1rem;
                border: 0;
                border-radius: 0.375rem;
                font-weight: 600;
                cursor: pointer;
                text-decoration: none;
                display: inline-block;
                transition: background-color 0.3s ease;

                &--primary {
                    background-color: #8b4513;

                    &:hover {
                        background-color: #654321;
                    }
                }
            }
        }
    }

    .app-main {
        flex-grow: 1;
        padding: 2rem 0;
    }

    .app-footer {
        background: #f3f4f6;
        text-align: center;
        padding: 1rem 0;
        color: #6b7280;
        font-size: 0.875rem;
    }
}
</style>
