<script>
export default {
  name: 'VoucherCard',
  props: {
    voucher: {
      type: Object,
      required: true,
    },
  },
};
</script>

<template>
  <div
    class="flex w-80 rounded-lg bg-[#f9f9fb] p-4 shadow-sm cursor-pointer transition-shadow duration-300 hover:shadow-lg hover:bg-gray-100"
    @click="$emit('redeem')"
  >
    <!-- Gambar -->
    <div class="mr-3 h-24 w-24 rounded-md overflow-hidden bg-gray-200">
      <img
        :src="voucher.image_url || '/images/logo.png'"
        alt="Voucher Image"
        class="h-full w-full object-cover"
      />
    </div>

    <!-- Detail -->
    <div>
      <span class="rounded bg-teal-700 px-2 py-0.5 text-xs text-white">
        {{ voucher.nilai_koin }} KOIN
      </span>
      <h3 class="mt-1 text-sm font-semibold">{{ voucher.nama_voucher }}</h3>
      <p class="text-xs text-gray-500">{{ voucher.deskripsi }}</p>
    </div>
  </div>
</template>

