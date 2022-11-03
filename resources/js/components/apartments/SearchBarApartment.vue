<template>
  <section>
    <div class="mt-5">
      <div class="row">
        <div class="col-12">
          <div class="form-group position-relative">
            <div id="address-tomtom">   
              <router-link
                :to="{ name: 'apartments-list', query: { address: dist } }" 
                >
                <button class="btn btn-outline-secondary search-btn"
                type="button"
                id="search">
                <i class="fa-solid fa-magnifying-glass"></i> Cerca
              </button>
              </router-link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import SearchBox from '@tomtom-international/web-sdk-plugin-searchbox';
import { services } from '@tomtom-international/web-sdk-services';
export default {
  name: "SearchBarApartment",
  data() {
    return {
      dist: null,
    };
  },
  methods: {
    searchWithDist(){
      this.$emit('searchWithDist', this.dist)
    },
    getSearchBox(){
      var options = {
          searchOptions: {
              key: 'k8P3Rx9lwVUMwJiJA3JF9ARIMpojuobA',
              language: 'it-IT',
              limit: 10,
          },
          autocompleteOptions: {
              key: 'k8P3Rx9lwVUMwJiJA3JF9ARIMpojuobA',
              language: 'it-IT',
          }
      };
      const addressContainer = document.getElementById("address-tomtom")
      var ttSearchBox = new SearchBox(services, options);
      var searchBoxHTML = ttSearchBox.getSearchBoxHTML();
      addressContainer.append(searchBoxHTML);
      const tomtomInput = document.getElementsByClassName("tt-search-box-input")[0];
      tomtomInput.setAttribute("class","input-tomtom");
      tomtomInput.addEventListener("input" , (e)=> {
        this.dist = e.target.value;
      })
      tomtomInput.addEventListener("change", (e) => {
        this.dist = e.target.value;
      })
      tomtomInput.addEventListener("keydown", (e) => {
        if (e.key === "Enter") {
          this.dist = e.target.value;
          this.searchWithDist();
        }
      });
    }
  },
  mounted() {
    this.getSearchBox();
    this.dist = this.$route.query.search;
  },
};
</script>

<style lang="scss">
.btn-outline-secondary {
  color: #2f4f4f;
  border-color: #2f4f4f;
  &:hover {
    background-color: #2f4f4f;
    color: white;
  }
}
.search-btn {
  position: absolute;
  z-index: 20;
  top: 0;
  right: 0px;
  bottom: 0;
}


// SearchBox Style
.tt-search-box-close-icon{
  display: none;
}
.tt-search-box{
  position: relative;
  .tt-search-box-input-container {
    border: 1px solid #ccc;
    background-color: white;
    padding: 9px 10px;
    display: flex;
    align-items: center;
    transition: border-color .2s ease,box-shadow .2s ease;
    .input-tomtom {
      border: 0px;
      width: 100%;
    }
    .input-tomtom:focus-visible {
      outline: none;
    }
  }
  .tt-search-box-result-list-container {
    max-height: 270px;
    overflow: auto;
    position: absolute;
    z-index: 10;
    width: 100%;
    box-shadow: 0 2px 9px -1px rgb(0 0 0 / 19%);
    .tt-search-box-result-list {
      background-color: #fff;
      cursor: pointer;
      height: auto;
      padding: 10px;
      border-bottom: 1px solid #edf2f7;
      color: #7a7e80;
      display: flex;
      align-items: center;
      .tt-search-box-result-list-text-content {
          white-space: nowrap;
          overflow: hidden;
          text-overflow: ellipsis;
          margin-right: 10px;
          display: inline;
      }
      .tt-search-box-result-list-bold {
          font-weight: 700;
          color: #000;
      }
    }
  }
}
</style>