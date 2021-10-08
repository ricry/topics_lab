<template>
  <div id="tab">
    <TabView ref="tabview1">
      <TabPanel header="トピック">
        <template #title>
            {{topic.title}}
          </template>
          <template #content>
            <div class="body-text">
              {{topic.body}}
            </div>
          </template>
      </TabPanel>
      <TabPanel header="コメント">
        <Comments :comments="this.comments" />
      </TabPanel>
    </TabView>
  </div>
</template>

<script>
import axios from '@/supports/axios'
import Comments from '@/components/Comments'
export default {
  components: {
    Comments
  },
  data () {
    return {
      user: {},
      topic: {},
      comments: [],
      id: null
    }
  },
  methods: {
    getTopic () {
      axios.get('/sanctum/csrf-cookie')
        .then(() => {
          axios.get(`/api/topic/${this.id}`)
            .then((res) => {
              if (res.status === 200) {
                this.topic = res.data
                this.user = this.topic.user
                this.comments.splice(0)
                this.comments.push(...this.topic.comments)
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

<style lang="scss" scoped>
.body-text {
  white-space:pre-wrap;
}
.p-card-footer span {
  text-align: right;
  display: block;
}
#tab {
  margin-top: 20px;
}
</style>
