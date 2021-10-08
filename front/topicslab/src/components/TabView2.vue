<template>
  <div id="tab">
    <TabView ref="tabview1">
      <TabPanel header="トピック">
        <div v-if="topics == 0">
          <Card>
            <template #content>
              <Skeleton width="30%" height="20px"></Skeleton>
              <Skeleton class="dummy-title" width="40%" height="40px"></Skeleton>
            </template>
          </Card>
        </div>
        <div v-else>
          <Card v-for="topic in topics" :key="topic.id">
            <template #content>
              <span class="topic-date">投稿日：{{moment(topic.created_at)}}</span>
              <h2>
                <router-link :to="`/topic/${topic.id}`">
                  {{topic.title}}
                </router-link>
              </h2>
            </template>
          </Card>
        </div>
      </TabPanel>
      <TabPanel header="コメント">
        <Comments :comments="comments" />
      </TabPanel>
    </TabView>
  </div>
</template>

<script>
import Comments from '@/components/Comments'
import moment from 'moment'

export default {
  components: {
    Comments
  },
  props: {
    comments: Array,
    topics: Array
  },
  data () {
    return {
      user: {},
      id: null
    }
  },
  methods: {
    moment: function (date) {
      return moment(date).format('YYYY/MM/DD HH:mm:SS')
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
