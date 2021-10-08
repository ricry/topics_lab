<template>
  <div id="tab">
    <TabView ref="tabview1">
      <TabPanel header="トピック">
        <div v-if="topics == 0">
          <Card>
            <template #content>
              <div v-if="loaded==false">
                <Skeleton width="30%" height="20px"></Skeleton>
                <Skeleton class="dummy-title" width="40%" height="40px"></Skeleton>
              </div>
              <div v-else>
                <p>投稿したトピックはありません</p>
              </div>
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
        <div v-if="comments==0">
          <p>投稿したコメントはありません</p>
        </div>
        <div v-else>
          <Comments :comments="comments" />
        </div>
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
    topics: Array,
    loaded: {
      type: Boolean,
      default: false
    }
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
.p-card.p-component {
  margin-bottom: 20px;
}
.p-card-content {
  .topic-date {
    font-size: 80%;
  }
}
.dummy-title {
  margin-top: 20px;
}
</style>
