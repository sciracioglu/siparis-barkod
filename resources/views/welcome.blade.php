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
        class="mt-8 max-w-3xl mx-auto grid grid-cols-1 gap-6 sm:px-6 lg:max-w-7xl lg:grid-flow-col-dense lg:grid-cols-3">
        <div class="space-y-6 lg:col-start-1 lg:col-span-2">
            <!-- Description list-->
            <section aria-labelledby="applicant-information-title">
                <div class="bg-white shadow sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6">
                        <h2 id="applicant-information-title" class="text-lg leading-6 font-medium text-gray-900">
                            Siparisler
                        </h2>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                            Firmaya gonderilecek urunler
                        </p>
                    </div>
                    <div class="border-t border-gray-200 px-4 py-5 sm:px-6" v-if="orders.length>0">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Ürün Adı
                                </th>

                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Miktarı
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Palet Miktarı
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Palet Bilgisi
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="(order,index) in orders" :key="index">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    @{{ order.MALKOD }} - @{{ order.MALAD }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @{{ order.MIKTAR }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @{{ order.PALETMIKTAR }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @{{ order.PALETBILGISI }}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

        </div>

        <section aria-labelledby="timeline-title" class="lg:col-start-3 lg:col-span-1">
            <div class="bg-white px-4 py-5 shadow sm:rounded-lg sm:px-6">
                <h2 id="timeline-title" class="text-lg font-medium text-gray-900">
                    Palete Eklenen
                </h2>

                <ul class="divide-y divide-gray-200" v-if="products.length>0">
                    <li class="py-4" v-for="(product,pindex) in products" :key="pindex">
                        <div class="flex space-x-3">
                            <div class="flex-1 space-y-1">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-sm font-medium">@{{ product.LOT }}</h3>
                                    <p class="text-sm text-gray-500"> @{{ product.MIKTAR }}</p>
                                </div>
                                <p class="text-sm text-gray-500"> @{{ product.MALKOD }}</p>
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="mt-6 flex flex-col justify-stretch">
                    <button type="button"
                            class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Advance to offer
                    </button>
                </div>
            </div>
        </section>
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
            computed: {
                totalCheck() {
                    const total = [];
                    for (i in this.products) {
                        total[i.MALKOD] = 0;
                    }
                    console.log(total);
                    this.orders.filter(function (elem) {
                        for (i in this.products) {
                            if (i.MALKOD === elem.MALKOD) {
                                total[i.MALKOD] += i.MIKTAR;
                                console.log(total);
                            }
                        }
                    });
                    return total;

                    // let sum = this.products.reduce((acc, item) => acc + item.MIKTAR, 0);
                    // return sum;
                }
            },
            methods: {
                find() {
                    let self = this;
                    axios.get('/barcode?barcode=' + this.search)
                        .then(({data}) => {
                            if (data.company && self.isCompany === true) {
                                alert('Acik firmanin isi bitmedi');
                            } else if (data.company && self.isCompany === false) {
                                self.company = data.company;
                                self.orders = data.orders;
                                self.isCompany = true;
                            }
                            if (data.products && self.isCompany === true) {
                                self.products.push(data.products);
                            } else if (data.products && self.isCompany === false) {
                                alert('once firma secmelisiniz');
                            }

                        });
                }
            }
        })
    </script>
@endsection
