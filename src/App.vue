<template>
  <div id="app">
    <el-menu
      class="el-menu-demo"
      mode="horizontal"
      background-color="#545c64"
      text-color="#fff"
      active-text-color="#ffd04b"
      unique-opened="true"
    >
      <el-menu-item index="1">Konomi Lab Computing Hub</el-menu-item>

      <el-submenu index="2">
        <template slot="title">Server Group</template>
        <div v-for="server in registered_servers" :key="server.id">
          <el-menu-item style="vertical-align:middle;" index="server.id">
            <div>
            {{server.server_name}}
            <i class="el-icon-circle-check" style="float:right;color:#67C23A"></i>
            </div>
          </el-menu-item>
        </div>
      </el-submenu>

      <el-menu-item index="3" disabled>Info</el-menu-item>
      <el-menu-item index="4" style="float:right">
        <a href="http://hdi.ait.kyushu-u.ac.jp" target="_black">
          <img src="./assets/logo.png" height="50px" />
        </a>
      </el-menu-item>
    </el-menu>
    <div>
      <el-button @click="get_registered_server_info">Start</el-button>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      available_modules: [
        "bandwidth",
        "cpu_info",
        "cpu_utilization",
        "current_ram",
        "gpu_stats",
        "general_info",
        "load_avg",
        "logged_in_users",
        "memory_info",
        "ip_addresses",
        "cpu_temp"
      ],
      registered_servers: null,
      response_data: null,
      search_results: null
    };
  },

  computed: {},

  created() {
    this.get_registered_server_info();
  },

  methods: {
    testRun() {
      for (let i = 0; i < this.available_modules.length; i++) {
        console.log(this.available_modules[i]);
        this.get_status(
          "http://localhost/server/index.php",
          this.available_modules[i]
        );
      }
    },

    get_registered_server_info() {
      this.$axios.get("/src/assets/registered_servers.json").then(response => {
        var self = this;
        self.registered_servers = response.data;

        console.log(self.registered_servers);
      });
    },

    get_status(api_endpoint, module) {
      this.$axios.get(api_endpoint + "?module=" + module).then(response => {
        var self = this;
        self.response_data = response.data;
        console.log(self.response_data);
        this.startHacking(module, self.response_data);
      });
    },

    startHacking(module_name, message_content) {
      this.$notify({
        title: module_name,
        type: "success",
        message: message_content,
        duration: 5000
      });
    }
  }
};
</script>

<style>
[v-cloak] {
  display: none;
}
#app {
  font-family: Helvetica, sans-serif;
  text-align: center;
}
</style>
