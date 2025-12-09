<template>
    <AppLayout>
        <div class="menu">
            <div class="container">
                <h2 class="menu__title">Меню кофе</h2>

                <div v-if="loading" class="menu__loading">Загрузка...</div>

                <div v-else class="menu__grid">
                    <article v-for="item in coffees" :key="item.id" class="card">
                        <div class="card__media">
                            <img v-if="item.image" :src="`data:image/jpeg;base64,${item.image}`" :alt="item.name"/>
                            <div v-else class="card__noimage">No image</div>

                            <span v-if="!item.available" class="card__badge">Нет в наличии</span>
                        </div>

                        <div class="card__body">
                            <h3 class="card__title">{{ item.name }}</h3>
                            <p class="card__desc">{{ item.description }}</p>

                            <div class="card__meta">
                                <span class="card__price">{{ formatPrice(item.price) }}</span>
                                <span class="card__size">{{ item.size?.ml }} ml</span>
                            </div>

                            <button :disabled="!item.available" class="card__button">
                                {{ item.available ? 'В корзину' : 'Недоступно' }}
                            </button>
                        </div>
                    </article>
                </div>

                <div v-if="pages > 1" class="menu__pagination">
                    <button :disabled="page === 1" @click="fetch(page - 1)">Prev</button>
                    <span>Страница {{ page }} из {{ pages }}</span>
                    <button :disabled="page === pages" @click="fetch(page + 1)">Next</button>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import {ref, onMounted} from 'vue'
import AppLayout from '@/Components/AppLayout.vue'
import axiosClient from '@/axios-client'

const coffees = ref([])
const loading = ref(false)
const page = ref(1)
const pages = ref(1)

const fetch = async (p = 1) => {
    loading.value = true
    try {
        const {data} = await axiosClient.get(`/coffee?page=${p}`)
        // data is paginated resource: { data: [...], meta: { ... } }
        coffees.value = data.data
        page.value = data.meta?.current_page ?? p
        pages.value = data.meta?.last_page ?? 1
    } catch (e) {
        console.error(e)
    } finally {
        loading.value = false
    }
}

onMounted(() => fetch())

const formatPrice = (val) => {
    if (val === null || val === undefined) return '0 ₽'
    // show integer if .00, otherwise show 2 decimals
    const num = Number(val)
    const rounded = Math.round(num) === num ? Math.round(num) : num.toFixed(2)
    return `${rounded} ₽`
}
</script>

<style scoped>
.container {
    max-width: 1120px;
    margin: 0 auto;
    padding: 2rem
}

.menu__title {
    font-size: 1.5rem;
    margin-bottom: 1rem;
    text-align: center
}

.menu__grid {
    display: grid;
    grid-template-columns:repeat(auto-fill, minmax(260px, 1fr));
    gap: 1rem
}

.card {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 1px 6px rgba(0, 0, 0, .06);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    height: 100%
}

.card__media {
    position: relative;
    height: 180px;
    background: #f6f6f6;
    display: flex;
    align-items: center;
    justify-content: center
}

.card__media img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block
}

.card__noimage {
    color: #999
}

.card__badge {
    position: absolute;
    left: 0;
    top: 0;
    background: #dc2626;
    color: #fff;
    padding: 0.25rem .5rem;
    border-bottom-right-radius: 6px
}

.card__body {
    padding: 1rem;
    display: flex;
    flex-direction: column;
    flex: 1
}

.card__title {
    margin: 0 0 .5rem;
    font-size: 1.125rem
}

.card__desc {
    flex: 1;
    color: #4b5563;
    margin-bottom: .75rem
}

.card__meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: .75rem
}

.card__price {
    font-weight: 700
}

.card__size {
    color: #6b7280
}

.card__button {
    background: #8b4513;
    color: #fff;
    border: 0;
    padding: .6rem;
    border-radius: 6px;
    cursor: pointer
}

.card__button:disabled {
    opacity: .5;
    cursor: not-allowed
}

.menu__pagination {
    display: flex;
    gap: .5rem;
    align-items: center;
    justify-content: center;
    margin-top: 1rem
}

.menu__loading {
    text-align: center;
    padding: 2rem
}
</style>
