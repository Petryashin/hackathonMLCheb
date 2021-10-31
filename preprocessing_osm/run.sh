osmconvert volga-fed-district-latest.osm -B="cheb.poly" --complete-ways --complete-multipolygons -o=cheb.pbf
osmconvert cheb.pbf -o=cheb.osm 
osmfilter cheb.osm --keep="leisure=pitch =park =playground" > filtered_parks.osm
osmfilter cheb.osm --keep="amenity=school" > filtered_school.osm                
osmfilter cheb.osm --keep="amenity=parking =parking_space" > filtered_parkings.osm