<template>
  <div class="main">
    <div class="leftBlock" v-if="selected">
      <div class="exit" @click="delEvent">
        <img style="height: 30px;width: 30px" :src="require('./assets/icons/xmark.svg')"/>
      </div>
      <div class="selectedTop" style="display: flex;justify-content: center;">
        <img style="height: 100px;width: 100px" :src="require(`./assets/icons/${selected.type}.svg`)"/>
      </div>
      <div class="selectedDescription" v-if="selected.adress">
        <p class="descriptionItem">Тип: {{ getRuType(selected.type) }}</p>
        <p class="descriptionItem">Адрес: {{ selected.adress }}<span
            v-if="selected.home">, дом {{ selected.home }}</span></p>
        <p class="descriptionItem">Описание: {{ selected.text_appeal }}</p>

      </div>
<!--      <div v-if="selected.comment" style="padding:10px;text-align:center">{{ selected.comment }}</div>-->
      <!--      <div style="display: flex;justify-content: center;align-items: center">-->
      <!--        <div-->
      <!--            style="padding: 10px;justify-content: center;display: flex;flex-direction: column;width: 200px;align-items: stretch;">-->
      <!--          <input v-model="comment" type="text"/>-->
      <!--          <button  class="commentBtn">Добавить комментарий</button>-->
      <!--        </div>-->
      <!--      </div>-->
      <div v-if="!selected.adress" style="padding-right: 10px; padding-left: 10px;overflow: visible">
        <div v-for="(event,key) in clusters" :key="key" class="selectedItems">
          <p>{{ event.adress }}</p>
          <p>{{ event.text_appeal }}</p>
        </div>
      </div>
      <div class="editForm">
      </div>
    </div>
    <l-map
        v-if="showMap"
        :zoom="zoom"
        :center="center"
        :options="mapOptions"
        @update:center="centerUpdate"
        @update:zoom="zoomUpdate"
    >
      <l-tile-layer
          :url="url"
          :attribution="attribution"
      />
      <l-marker :lat-lng="[cluster.lat,cluster.lng]" v-for="cluster in mainClusters" :key="cluster.id"
                @click="selectCluster(cluster)">
        <l-icon>
          <img style="border-radius: 50%;border: 2px solid black;height: 50px;width: 50px;"
               :src="require(`./assets/icons/${cluster.type}.svg`)"/>
        </l-icon>

      </l-marker>
      <l-marker :lat-lng="[tooltip.lat,tooltip.lng]" v-for="tooltip in clusters" :key="tooltip.id"
                @click="selectEvent(tooltip)">
        <l-icon>
          <img :src="require(`./assets/icons/${tooltip.type}.svg`)"/>
        </l-icon>
      </l-marker>
      <template v-if="selected">
        <l-marker :lat-lng="[mapPoint.lat,mapPoint.lng]" v-for="mapPoint in openMapInfo" :key="mapPoint.id">
          <l-icon>
          </l-icon>
        </l-marker>
      </template>

      <l-control-zoom position="topright">
      </l-control-zoom>
      <l-control class="custom-control">
        <div>
          <p class="filterButton" @click="filterOpen=!filterOpen">Фильтр</p>
          <div style="position: absolute;right: 5px;top: 5px" v-if="filterOpen" @click="filterOpen=!filterOpen">
            <img :src="require('./assets/icons/xmark.svg')"/>
          </div>
          <div class="filterItems" v-if="filterOpen">
            Фильтр по обращениям
            <p v-for="(type,eng) in keys" :key="eng" @click="getFilter(eng)">
            <span v-if="filteredKeys.includes(eng)">
             ✓
            </span>
              <span v-else>
                *
              </span>
              <span>{{ type }}</span>
            </p>
          </div>

        </div>
      </l-control>
    </l-map>
  </div>
</template>

<script>
import {latLng} from "leaflet";
import {LMap, LTileLayer, LMarker, LControlZoom, LIcon, LControl} from "vue2-leaflet";
import {api} from "./api/api";

export default {
  name: "App",
  components: {
    LMap,
    LTileLayer,
    LMarker,
    LControlZoom,
    LIcon,
    LControl
  },
  data() {
    return {
      comment: null,
      showEvents: true,
      mainKeys: [],
      mainClusters: [],
      filteredKeys: [],
      filterItems: null,
      filterOpen: false,
      filter: [],
      constFilter: [],
      clusters: [],
      iconSize: 30,
      selected: null,
      oldZoom: null,
      oldPos: null,
      keys: {},
      zoomTimeout: () => this.zoom = 16.5,
      zoomCluster: () => this.zoom = 15,
      zoom: 13.5,
      center: latLng(56.121449, 47.253489),
      url: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
      attribution:
          '<span>Hackermans</span>',
      withPopup: latLng(56.129849, 47.263889),
      withTooltip: latLng(56.119449, 47.253489),
      currentZoom: 13.5,
      currentCenter: latLng(47.41322, -1.219482),
      showParagraph: false,
      mapOptions: {
        zoomSnap: 0.5,
        zoomControl: false
      },
      attributionControl: false,
      showMap: true,
      openMapInfo: null,
      openMapKeys: null
    };
  },
  async created() {
    await this.getApiClusters()
    await this.getOpenMap()
    // await api.getCategories().then(res => res.json()).then(data => {
    //   console.log(data)
    //   this.keys = data.keys
    //   this.filteredKeys = Object.keys(data.keys)
    //   this.constFilter = Object.values(data.keys)
    //   this.clusters = Object.values(data.data).flat()
    // })
  },
  methods: {

    async getOpenMap() {
      await api.getOpenMap().then(res => res.json()).then(data => {
        this.openMapInfo = data.data
        this.openMapKeys = data.keys
      })
    },
    async getApiClusters() {
      await api.getClusters().then(res => res.json()).then(data => {
        console.log(data)
        this.keys = data.keys
        this.filteredKeys = Object.keys(data.keys)
        this.mainClusters = Object.values(data.data).flat()
        this.mainKeys = data.keys
      })
    },
    getRuType(name) {
      return this.keys[name]
    },
    async getFilter(eng) {
      if (this.filteredKeys.includes(eng)) {
        this.filteredKeys = this.filteredKeys.filter(el => el !== eng)
      } else {
        this.filteredKeys.push(eng)
      }
      await api.getFilter(this.filteredKeys).then(res => res.json()).then(data => {
        this.clusters = Object.values(data.data).flat()
      })
    },
    async selectCluster(cluster) {
      if (!this.selected) this.oldZoom = this.currentZoom
      this.mainClusters = this.mainClusters.filter(el => el.type === cluster.type)
      this.openMapInfo = this.openMapInfo.filter(el => {
        if (cluster.type === 'school') {
          return el.type === 'school'
        }
        if (cluster.type === 'Parking') {
          return el.type === 'parkings'
        }
        if (cluster.type === 'Playground') {
          return el.type === 'leisure'
        }
      })
      this.center = latLng(cluster.lat, cluster.lng)
      this.selected = cluster
      await api.getCluster(cluster.id).then(res => res.json()).then(data => {
        this.clusters = data
      })
      setTimeout(this.zoomCluster, 300)

    },
    selectEvent(tooltip) {
      if (!this.selected) this.oldZoom = this.currentZoom
      this.center = latLng(tooltip.lat, tooltip.lng)
      this.selected = tooltip
      setTimeout(this.zoomTimeout, 500)
    },
    delEvent() {
      this.clusters = null
      this.getApiClusters()
      this.getOpenMap()
      this.selected = null
      this.zoom = this.oldZoom
    },
    zoomUpdate(zoom) {

      this.currentZoom = zoom;
    },
    centerUpdate(center) {
      this.currentCenter = center;
    },
  },
  watch: {
    filterItems: function (curValue) {
      console.log(curValue)
    },
    clusters: function (val) {
      console.log(val)
    }
  }
};
</script>

<style>

* {
  box-sizing: border-box;
}

body {
  padding: 0;
}
</style>
<style scoped>
.commentBtn {
  background-color: white;
  color: black;
  font-size: 15px;
  border-radius: 5px;
  text-align: center;
  border: none;
  box-shadow: 0 0 4px gray;
  margin-top: 5px;
}

.selectedItems {
  box-shadow: 0 0 10px #d0d0d0;
  padding: 10px;
  border-radius: 10px;
  margin-bottom: 10px;
  font-family: TT Firs Neue;
  font-size: 16px;
  font-style: normal;
  font-weight: 400;
  line-height: 21px;
  letter-spacing: 0em;
  text-align: left;
}

.filterItems {
  transition-duration: 1s;
}

.descriptionItem {
  font-size: 1.2rem;
}

.selectedTop {
  display: flex;
  justify-content: center;
  align-items: center;
  border-radius: 20px;
  padding-top: 20px;
  padding-bottom: 20px;
  background-color: #f5f2f3;
  box-sizing: border-box;
  box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.50);
  margin-bottom: 10px;
}

.selectedDescription {
  background-color: white;
  border-top-right-radius: 10px;
  border-top-left-radius: 10px;
  padding-left: 20px;
  padding-right: 20px;
  box-sizing: border-box;
  overflow-y: auto;
  font-family: TT Firs Neue;
  font-size: 16px;
  font-style: normal;
  font-weight: 500;
  line-height: 21px;
  letter-spacing: 0em;
  text-align: left;
}

.filterButton {
  text-align: center;
  transition: 1s;
}

.custom-control {
  background: #fff;
  padding: 0 0.5em;
  border: 1px solid #aaa;
  border-bottom: 3px solid gray;
  border-radius: 10px;
  cursor: pointer;
  transition-duration: 1s;
}

.exit {
  position: absolute;
  top: 20px;
  right: 20px;
  height: 30px;
  width: 30px;
  cursor: pointer;
}

.exit:hover {
  background: #e0e0e0;
  border-radius: 50%;
}

.leftBlock {
  font-family: Geneva, Arial, Helvetica, sans-serif;
  position: fixed;
  z-index: 10000;
  width: 30%;
  height: 94%;
  top: 3%;
  left: 2%;
  border-radius: 20px;
  box-sizing: border-box;
  border-bottom: 4px solid gray;
  background-color: white;
  overflow: auto;
}

.main {
  position: fixed;
  height: 100%;
  width: 100%;
  top: 0;
  left: 0;
}

</style>
