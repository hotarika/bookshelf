<template>
    <div class="p-myBooks">
        <h1 class="c-h1__head"><i class="fas fa-bookmark"></i>私の本棚</h1>
        <div class="c-form__searchSection">
            <div class="p-myBooks__selectBoxWrap">
                <!-- 評価順 -->
                <select
                    class="p-myBooks__selectStar"
                    name="star"
                    id=""
                    v-model="star"
                >
                    <option value="0">★の数で選択</option>
                    <option value="1">★１以上</option>
                    <option value="2">★２以上</option>
                    <option value="3">★３以上</option>
                    <option value="4">★４以上</option>
                    <option value="5">★５以上</option>
                </select>

                <!-- 読了日順 -->
                <select
                    name="latest_date"
                    id=""
                    class="p-myBooks__selectLatestDate"
                    v-model="latestDate"
                >
                    <option value="0">読了日順で選択</option>
                    <option value="1">新しい順</option>
                    <option value="2">古い順</option
                    ><option value="3">読書中の表示</option>
                </select>
            </div>

            <!-- 検索ボックス -->
            <div class="c-form__searchBoxWrap">
                <input
                    class="c-form__searchInput"
                    type="text"
                    v-model="search"
                    placeholder="書籍を絞り込む（タイトル・著者名）"
                />
                <button class="c-form__searchBtn" type="">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>

        <div class="p-myBooks__cards">
            <template v-for="(book, i) of showBooks.slice(0, showNum)">
                <a
                    :href="publicPath + 'bookshelf/' + book.id"
                    class="p-myBooks__cardLink"
                    :key="book.id"
                >
                    <bookshelf-book-card-component
                        :book="book"
                        :public-path="publicPath"
                        @delete-book="deleteBook"
                        :i="i"
                    ></bookshelf-book-card-component>
                </a>
            </template>
        </div>
        <img
            class="p-myBooks__googlePoweredbyLogo"
            :src="publicPath + 'image/poweredby.png'"
            alt=""
        />

        <a
            class="p-myBooks__noBooksMsg"
            :href="publicPath + 'bookshelf/create'"
            v-if="books.length === 0"
            >読んだ書籍を追加しましょう！<br />（ここをクリック）</a
        >

        <button
            class="p-myBooks__showMore"
            v-if="showBooks.length >= showNum"
            @click.prevent="showMore"
        >
            さらに表示
        </button>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    props: {
        publicPath: String
    },
    data() {
        return {
            search: '',
            star: 0,
            latestDate: 0,
            books: [],
            showNum: 12,
            addItemsNum: 12
        };
    },
    methods: {
        showMore() {
            return (this.showNum = this.showNum + this.addItemsNum);
        },
        deleteBook(emit) {
            axios
                .delete(this.publicPath + 'bookshelf/' + emit.id)
                .then(res => {
                    const index = this.books.indexOf(emit);
                    this.books.splice(index, 1);
                    console.log(res);
                })
                .catch(err => {
                    console.log(err);
                });
        }
    },
    computed: {
        showBooks() {
            const regexp = new RegExp(this.search.trim(), 'i'); // i = 大小区別しない
            // const that = this;
            let filteredBooks = [];

            // ************************
            if (this.latestDate == 1 || this.latestDate == 2) {
                // 読書中の書籍を削除
                const removeReadingBooks = this.books.filter(
                    book => book.read_at != null
                );
                filteredBooks = removeReadingBooks; // 読書中を削除したデータを代入
                console.log(filteredBooks);

                // 並び替え
                if (this.latestDate == 2) {
                    // 並び替え
                    filteredBooks = filteredBooks.slice().sort((a, b) => {
                        if (a.read_at > b.read_at) return -1;
                        if (a.read_at < b.read_at) return 1;
                    });
                } else {
                    filteredBooks = filteredBooks.slice().sort((a, b) => {
                        if (a.read_at < b.read_at) return -1;
                        if (a.read_at > b.read_at) return 1;
                    });
                }
            } else if (this.latestDate == 3) {
                // 読書中の書籍を選択
                const selectReadingBooks = this.books.filter(
                    book => book.read_at === null
                );
                filteredBooks = selectReadingBooks; // 読書中の書籍を選択して代入
            } else {
                // 読了日順が何も指定されていない場合には、そのまま全てのデータを格納
                filteredBooks = this.books;
            }

            // ************************

            // フィルター
            return filteredBooks
                .slice()
                .reverse()
                .filter(el => {
                    if (el.author === null) {
                        el.author = '';
                    }
                    if (!el.title.match(regexp) && !el.author.match(regexp)) {
                        return;
                    }

                    if (el.star < Number(this.star)) {
                        return;
                    }

                    return el;
                });
        }
    },
    mounted() {
        // 書籍の一覧表示
        axios
            .get(this.publicPath + 'async/bookshelf')
            .then(res => {
                // console.log(res);
                this.books = res.data;
            })
            .catch(err => {
                console.log(err);
            });
    }
};
</script>
