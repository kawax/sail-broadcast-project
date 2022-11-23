<script setup>
import InputError from '@/Components/InputError.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import TextInput from '@/Components/TextInput.vue'
import { useForm, usePage } from '@inertiajs/inertia-vue3'
import { ref } from 'vue'

const items = ref([])

const user = usePage().props.value.auth.user

const form = useForm({
    chat: 'test',
})

const submit = () => {
    form.post(route('presence.create'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset()
        },
        onError: () => {
            console.log(form)
        },
    })
}

Echo.join('presence').here((users) => {
    items.value.unshift({
        'name': 'システム',
        'chat': '現在の参加者 : ' + _.map(users, 'name').join(', '),
        'datetime': '',
    })
    console.log(users)
}).joining((user) => {
    items.value.unshift({
        'name': 'システム',
        'chat': user.name + 'が参加',
        'datetime': '',
    })
    console.log('joining: ' + user.name)
}).leaving((user) => {
    items.value.unshift({
        'name': 'システム',
        'chat': user.name + 'が退出',
        'datetime': '',
    })
    console.log('leaving: ' + user.name)
}).error((error) => {
    console.error(error)
}).listen('PresenceSubmit', (e) => {
    items.value.unshift({
        'name': e.name,
        'chat': e.chat,
        'datetime': e.datetime,
    })
})
</script>

<template>
    <section>
        <h2 class="text-2xl">PresenceChannel</h2>

        <form @submit.prevent="submit" class="mt-6 space-y-2">
            <div>
                {{ user.name }}
            </div>

            <div>
                <TextInput id="chat" type="text" class="block w-full" v-model="form.chat" required/>
                <InputError class="mt-2" :message="form.errors.chat"/>
            </div>

            <div>
                <PrimaryButton :disabled="form.processing">Submit</PrimaryButton>
            </div>
        </form>

        <div class="my-6">
            <div v-for="item of items" class="border-b">
                <span class="font-bold text-indigo-500">{{ item.name }}</span>
                <span class="mx-5">{{ item.chat }}</span>
                <span class="text-gray-300 text-sm">{{ item.datetime }}</span>
            </div>
        </div>
    </section>
</template>
