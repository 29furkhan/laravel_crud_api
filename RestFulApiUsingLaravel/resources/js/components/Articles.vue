<template>
    <div class="container">
        <form class="mb3" @submit.prevent="addArticle">
            <div class="form-group">
                <input type="text" name=""  class="form-control" placeholder="Title" v-model="article.title">
            </div>
            <div class="form-group">
                <textarea class="form-control" placeholder="Body" v-model="article.body">  
                </textarea> 
            </div>
            <div>
                <button class="btn btn-light btn-block"> Save</button>
            </div>
            <br>
        </form>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li v-bind:class="[{disabled:!pagination.prev_page_url}]" class="page-item">
                    <a class="page-link" href="#" @click="fetchArticles(pagination.prev_page_url)">Previous</a>
                </li>

                <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page}} of {{pagination.last_page}}</a></li>
                
                <li  v-bind:class="[{disabled:!pagination.next_page_url}]" class="page-item" >
                    <a class="page-link" href="#" @click="fetchArticles(pagination.next_page_url)">Next</a>
                </li>
            </ul>
        </nav>
        <div class="card card-body mb-2" v-for="article in articles" v-bind:key="article.id">
            <h3>{{article.title}}</h3>
            <p>{{article.body}}</p>
            <button @click="editArticle(article)" class="btn btn-warning mb-2">EDIT</button>
            <button @click="deleteArticle(article.id)" class="btn btn-danger">DELETE</button>
        </div>    
    </div>
</template>

<script>
export default {
    data(){
        return{
            articles: [],
            article:{
                id:"",
                title:"",
                body:""
            },
            article_id:'',
            pagination:{},
            edit:false
        }
    },
    created(){
        this.fetchArticles();
    },
    methods:{
        fetchArticles(page_url){
            let vm = this;
            // alert(page_url);
            page_url = page_url || 'api/articles';
            fetch(page_url)
            .then(res => res.json())
            .then(res => {
                this.articles = res.data; 
                vm.makePagination(res.meta,res.links)
            })
            .catch(err => console.log(err))
        },
        makePagination(meta,links){
            let pagination = {
                current_page: meta.current_page,
                last_page:meta.last_page,
                next_page_url:links.next,
                prev_page_url:links.prev
            } 
            // alert('next_page_url');
            this.pagination = pagination;
        },
        deleteArticle(id){
            if(confirm("Are You Sure?")){
                fetch(`api/article/${id}`,{
                    method:'delete'
                })
                .then(res => res.json())
                .then(data => {
                    alert('Article Removed');
                    this.fetchArticles();
                }) 
            }
        },
        addArticle(){
            if(this.edit==false){
                //Add
                // alert(JSON.stringify(this.article));
                fetch('api/article',{
                    method:'post',
                    body:JSON.stringify(this.article),
                    headers:{
                        'content-type':'appication/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    this.articles.title = ' ';
                    this.article.body = '';
                    alert('Article Added');
                    this.fetchArticles();
                })
                .catch(err => console.log(err))
            }
            else{
                fetch('api/article',{
                    method:'put',
                    body:JSON.stringify(this.article),
                    headers:{
                        'content-type':'appication/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    this.articles.title = ' ';
                    this.article.body = '';
                    alert('Article Updated');
                    this.fetchArticles();
                })
                .catch(err => console.log(err))
            }
        },
        editArticle(article){
            this.edit = true;
            this.article.id = article.id;
            this.article.article_id = article.id;
            this.article.title = article.title;
            this.article.body = article.body;
        }
    }
}
</script>