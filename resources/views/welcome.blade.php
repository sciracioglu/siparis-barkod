@extends('layouts.app')

@section('header')
    Deneme
@endsection

@section('content')
    <div
        class="max-w-3xl mx-auto px-4 sm:px-6 md:flex md:items-center md:justify-between md:space-x-5 lg:max-w-7xl lg:px-8">
        <div class="flex items-center space-x-5">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">@{{ company.FATURAUNVAN }}</h1>
                <p class="text-sm font-medium text-gray-500">@{{ company.HESAPKOD }}
                    <time datetime="2020-08-25">@{{ company.EVRAKNO }}</time>
                </p>
            </div>
        </div>
        <div
            class="mt-6 flex flex-col-reverse justify-stretch space-y-4 space-y-reverse sm:flex-row-reverse sm:justify-end sm:space-x-reverse sm:space-y-0 sm:space-x-3 md:mt-0 md:flex-row md:space-x-3">

        </div>
    </div>

    <div
        class="mt-8 max-w-3xl mx-auto grid grid-cols-1 gap-6 sm:px-6 lg:max-w-7xl lg:grid-flow-col-dense prose">
        <div class="space-y-6 lg:col-start-1 lg:col-span-2 ">
            <!-- Description list-->
            <section aria-labelledby="applicant-information-title">
                <div class="bg-white shadow sm:rounded-lg">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="px-4 py-5 sm:px-6">
                            <h2 id="applicant-information-title" class="text-lg leading-6 font-medium text-gray-900">
                                Siparişler
                            </h2>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                Firmaya gönderilecek ürünler
                            </p>
                        </div>

                            <div class="mt-4 flex-1 flex items-center justify-center px-2 lg:ml-6 lg:justify-end">
                                <div class="max-w-lg w-full lg:max-w-xs">
                                    <label for="search" class="sr-only">Search</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <!-- Heroicon name: solid/search -->
                                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                                 viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd"
                                                      d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                                      clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                        <input id="search" name="search" v-model="search" v-on:keyup.enter="find()"
                                               class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white shadow-sm placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-600 focus:border-blue-600 sm:text-sm"
                                               placeholder="Barkod okutun..." type="search">
                                    </div>
                                </div>
                            </div>
                    </div>

                    <div class="border-t border-gray-200 px-4 py-5 sm:px-6" v-if="orders.length>0">
                        <div v-for="(order,index) in orders" :key="index"
                             class="pl-3 pr-3 grid grid-cols-3 gap-4 mb-3 border-b-2 border-gray-200	rounded">
                            <div class="col-start-1 col-end-3">@{{ order.MALKOD }} - @{{ order.MALAD }}</div>
                            <div class="text-right col-start-4 col-end-5">Miktar : <span class=" font-black"> @{{ parseInt(order.MIKTAR) }}</span></div>
                            <div class="col-start-6 col-end-7">Palet @{{ order.PALETBILGISI }} : @{{ parseInt(order.PALETMIKTAR) }}</div>
                            <div class="col-span-6 m-1" v-for="(product,pindex) in products"
                                 v-if="pindex == order.MALKOD && product[0].length > 0" :key="pindex">
                                <div v-for="(prdk,ndx) in product[0]" :key="ndx"
                                     class="pl-3 pr-3 pt-1 pb-1 mb-1 grid grid-cols-3 gap-4 bg-yellow-50 border-b-2 border-yellow-100 rounded">
                                    <div class="col-start-1 col-end-3">@{{ prdk.LOTNO }}</div>
                                    <div class="text-right col-start-4 col-end-5 font-black">@{{ parseInt(prdk.MIKTAR) }}</div>
                                    <div class="text-right col-start-6 col-end-7">
                                        <button
                                            type="button"
                                            @click="destroy(prdk.EVRAKNO, prdk.LOTNO)"
                                            class="inline-flex items-center p-2 border border-transparent rounded-full shadow-sm text-white bg-red-800 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                            <svg  class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div
                                    class="pl-3 pr-3 pt-1 pb-1 mb-1 grid grid-cols-3 gap-4  border-b-2  rounded"
                                    :class="itemClass(pindex,index)"
                                >
                                    <div class="col-start-1 col-end-3">Toplam : </div>
                                    <div class="text-right col-start-4 col-end-5 font-black">@{{ itemsWithSubTotal(pindex) }}</div>
                                    <div class="text-right col-start-6 col-end-7">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
@section('script')
    <script>
        const vm = new Vue({
            el: '#app',
            data: {
                search: '',
                message: 'serkan',
                isCompany: false,
                isDone: false,
                company: [],
                orders: [],
                products: [],
            },
            methods: {
                itemClass(pindex, oindex){
                  toplam = parseInt(this.itemsWithSubTotal(pindex));
                  giden = parseInt(this.orders[oindex].MIKTAR);
                    if(toplam < giden){
                        return 'bg-yellow-200 border-yellow-300 text-yellow-500';
                    }
                    if(toplam === giden){
                        return 'bg-green-200 border-green-300 text-green-500';
                    }
                    if(toplam > giden){
                        return 'bg-red-400 border-red-500 text-red-800';
                    }
                },
                itemsWithSubTotal(pindex) {
                    let items = this.products[pindex];
                    let toplam = 0;
                    if(items && items.length > 0) {
                        Object.keys(items).forEach(key => {
                            const item = items[key];
                            toplam = _.sumBy(item, function(o){ console.log(o); return parseInt(o.MIKTAR)});
                        })
                    }
                    return toplam;
                },
                find() {
                    let self = this;
                    axios.get('/barcode?barcode=' + this.search)
                        .then(({data}) => {
                            if (data && self.isCompany === true) {
                                alert('Acik firmanin isi bitmedi');
                                self.search = '';
                            } else if (data && self.isCompany === false) {
                                self.company = data;
                                self.isCompany = true;
                                self.paletReload();
                                self.search = '';
                            }
                            if (!data && self.isCompany === true) {
                               this.paletStore();
                            } else if (!data && self.isCompany === false) {
                                alert('once firma secmelisiniz');
                            }

                        });
                },
                bul(){
                    var items = this.products;
                    let result = false;
                    var self = this;
                    Object.keys(items).forEach(key => {
                        const item = items[key]
                        if(self.search != '' && item.length > 0){
                            let find = _.find(item[0], function(o) {
                                return o.LOTNO == self.search
                            });
                            if(find){
                                result = true;
                            }
                        }
                    })
                    return result;
                },
                paletStore(){
                    let self=this;
                    let bul = this.bul();
                    if(!this.bul()) {
                        axios.post('/barcode', {lotno: this.search, evrakno: this.company.EVRAKNO})
                            .then(function (response) {
                                self.paletReload();
                            });
                    }
                    self.search = '';
                },
                paletReload(){
                    let self = this;
                  axios.get('/palet-list')
                    .then(({data})=>{
                        self.orders = data.orders;
                        self.products = data.products;
                    });
                },
                destroy(evrak_no, lot_no){
                    let self = this;
                    axios.delete('/barcode-delete/'+evrak_no+'/'+lot_no)
                    .then(function(){
                        self.paletReload();
                    });
                }
            }
        })
    </script>
@endsection
