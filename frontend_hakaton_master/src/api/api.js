export const path = 'http://stratificationwater.ddns.net:8080/api'

export const api = {
    async getCategories(){
        return await fetch(`${path}/categories`)
    },
    async getClusters(){
        return await fetch(`${path}/clusters`)
    },
    async getFilter(arrFilter){
        return await fetch(`${path}/categories/filter`,{method:"POST",headers:{'Content-Type': 'application/json'},body:JSON.stringify(arrFilter)})
    },
    async getCluster(id){
        return await fetch(`${path}/clusters/appeals/?cluster_id=${id}`)
    },
    async getOpenMap(){
        return await fetch(`${path}/openstreetmap`)
    }

}
