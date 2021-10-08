<template>
  <div>
    <div v-if="!user.name">
      <Card>
        <template #content>
          <Skeleton width="15%" height="20px"></Skeleton>
        </template>
      </Card>
    </div>
    <div v-else>
      <Card>
        <template #content>
          {{user.name}}
          <TabView :tabview="this.tabview" />
        </template>
      </Card>
    </div>
  </div>
</template>

<script>
import axios from '@/supports/axios'
import TabView from '@/components/TabView2'
export default {
  name: 'user',
  components: {
    TabView
  },
  data () {
    return {
      user: {}
    }
  },
  mounted () {
    if (localStorage.getItem('authenticated') !== 'true') {
      alert('ログインしてください。')
      this.$router.push('/login')
      return
    }
    this.id = this.$route.params.id
    if (!this.id) {
      alert('不正なIDです。')
      this.$router.push('/login')
      return
    }
    this.getUser()
  },
  methods: {
    getUser () {
      axios.get('/sanctum/csrf-cookie')
        .then(() => {
          axios.get(`/api/user/${this.id}`)
            .then((res) => {
              console.log(res)
              if (res.status === 200) {
                this.user = res.data
              } else {
                console.log('取得失敗')
              }
            })
            .catch((err) => {
              console.log(err)
            })
        })
        .catch((err) => {
          alert(err)
        })
    }
  }
}
</script>
