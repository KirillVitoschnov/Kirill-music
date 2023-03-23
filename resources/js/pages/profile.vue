<template>
  <div class="main-wrapper">
    <v-sidebar />
    <v-content>
      <div class="profile-wrapper">
        <h1>Профиль</h1>
        <div v-if="user" class="profile-table-wrapper">
          <tbody class="profile-table">
            <tr>
              <td>Имя пользователя</td>
              <td> {{ user.name }}</td>
            </tr>
            <tr>
              <td>Электронная почта</td>
              <td> {{ user.email }}</td>
            </tr>
            <tr>
              <td>Дата рождения</td>
              <td> {{ user.birthdate | Dateify }}</td>
            </tr>
            <tr>
              <td>Редактировать</td>
              <td>
                <button @click="$bvModal.show('profile-edit')">
                  Редактировать профиль
                </button>
              </td>
            </tr>
          </tbody>

          <div class="profile-photo-wrapper">
            <button class="del-avatar" @click="image='';update()">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M12 0C5.37187 0 0 5.37187 0 12C0 18.6281 5.37187 24 12 24C18.6281 24 24 18.6281 24 12C24 5.37187 18.6281 0 12 0ZM16.8094 7.17656C16.4789 6.84844 15.9445 6.84844 15.6164 7.17891L12 10.8047L8.38359 7.17891C8.05547 6.84844 7.52109 6.84844 7.19062 7.17656C6.86016 7.50469 6.86016 8.03906 7.18828 8.36953L10.8094 12L7.18828 15.6305C6.86016 15.9609 6.86016 16.4953 7.19062 16.8234C7.35469 16.9875 7.57031 17.0695 7.78594 17.0695C8.00156 17.0695 8.21953 16.9875 8.38359 16.8211L12 13.1953L15.6164 16.8234C15.7805 16.9898 15.9984 17.0719 16.2141 17.0719C16.4297 17.0719 16.6453 16.9898 16.8094 16.8258C17.1398 16.4977 17.1398 15.9633 16.8117 15.6328L13.1906 12L16.8094 8.36953C17.1398 8.03906 17.1398 7.50469 16.8094 7.17656ZM16.0125 21.5016C17.2406 20.9836 18.3445 20.2383 19.2914 19.2914C20.2406 18.3445 20.9836 17.2406 21.5039 16.0125C22.0406 14.7422 22.3125 13.3922 22.3125 12C22.3125 10.6078 22.0406 9.25781 21.5016 7.98516C20.9836 6.75703 20.2383 5.65312 19.2914 4.70625C18.3422 3.75938 17.2406 3.01641 16.0125 2.49609C14.7422 1.95938 13.3922 1.6875 12 1.6875C10.6078 1.6875 9.25781 1.95938 7.98516 2.49844C6.75703 3.01641 5.65312 3.76172 4.70625 4.70859C3.75938 5.65781 3.01641 6.75938 2.49609 7.9875C1.95938 9.25781 1.6875 10.6078 1.6875 12C1.6875 13.3922 1.95938 14.7422 2.49844 16.0148C3.01641 17.243 3.76172 18.3469 4.70859 19.2938C5.65781 20.2406 6.75938 20.9836 7.9875 21.5039C9.25781 22.0406 10.6078 22.3125 12 22.3125C13.3922 22.3125 14.7422 22.0406 16.0125 21.5016Z"
                      fill="black"
                />
              </svg>
            </button>
            <img onclick="document.getElementById('imageUpload').click()" class="profile-img" :src="user.photo_url">
            <div class="avatar-edit">
              <input id="imageUpload" type="file" name="user_img" accept=".png, .jpg, .jpeg" @change="onFileChange">
              <label for="imageUpload">Обновить аватар</label>
            </div>
          </div>
        </div>
        <button class="logout-profile" @click="logout">
          Выйти
        </button>
        <b-modal id="profile-edit" title="BootstrapVue">
          <p class="my-4">
            Hello from modal!
          </p>
        </b-modal>
      </div>
    </v-content>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import Form from 'vform'

export default {
  components: {},
  filters: {
    Dateify: function (value) {
      let data
      const d = new Date(value)
      if (d.getMonth() < 9) {
        data = d.getDate() + '.' + 0 + (+d.getMonth() + 1) + '.' + d.getFullYear()
      } else {
        data = d.getDate() + '.' + (+d.getMonth() + 1) + '.' + d.getFullYear()
      }

      return data
    }
  },

  layout: 'basic',
  middleware: 'auth',

  metaInfo () {
    return { title: 'Профиль' }
  },

  data: () => ({
    title: window.config.appName,
    image: '',
    form: new Form({
      name: '',
      email: '',
      user_img: ''

    })
  }),
  created () {
    this.form.keys().forEach(key => {
      this.form[key] = this.user[key]
    })
  },
  methods: {
    async logout () {
      await this.$store.dispatch('auth/logout')
      this.$router.push({ name: 'welcome' })
    },
    onFileChange: function (e) {
      const files = e.target.files || e.dataTransfer.files
      if (!files.length) { return }
      this.createImage(files[0])
    },
    createImage: function (file) {
      const reader = new FileReader()
      const vm = this
      reader.onload = function (e) {
        vm.image = e.target.result
        vm.update()
      }
      reader.readAsDataURL(file)
    },
    async update () {
      if (this.image) {
        this.form.user_img = this.image
      } else {
        this.form.user_img = ''
      }
      const { data } = await this.form.patch('/api/settings/profile')
      this.$store.dispatch('auth/updateUser', { user: data })
    }
  },

  computed: mapGetters({
    authenticated: 'auth/check',
    user: 'auth/user'
  })
}
</script>

<style scoped>
.top-right {
  position: absolute;
  right: 10px;
  top: 18px;
}

.title {
  font-size: 85px;
}
</style>
