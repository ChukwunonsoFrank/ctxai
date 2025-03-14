@extends('user.layout.layout')

@section('content')
    <div class="container mx-auto px-4 pb-36 lg:pl-24 mt-2">
        <h1 class="text-[#FFFFFF] text-xl font-bold my-6 md:text-3xl">Frequently Asked Questions</h1>
        <div x-data="{ selectedAccordionItem: 'one' }"
            class="w-full divide-y divide-neutral-300 overflow-hidden rounded-lg bg-neutral-50/40 text-[#FFFFFF]">
            <div>
                <button id="controlsAccordionItemOne" type="button"
                    class="flex w-full items-center justify-between gap-4 bg-[#1e1f2a] p-4 text-left underline-offset-2 hover:bg-neutral-50/75 focus-visible:bg-neutral-50/75 focus-visible:underline focus-visible:outline-hidden dark:bg-neutral-900 dark:hover:bg-neutral-900/75 dark:focus-visible:bg-neutral-900/75"
                    aria-controls="accordionItemOne" x-on:click="selectedAccordionItem = 'one'"
                    x-bind:class="selectedAccordionItem === 'one' ?
                        'text-onSurfaceStrong dark:text-onSurfaceDarkStrong font-bold' :
                        'text-onSurface dark:text-onSurfaceDark font-medium'"
                    x-bind:aria-expanded="selectedAccordionItem === 'one' ? 'true' : 'false'">
                    How does Nxcai works?
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2"
                        stroke="currentColor" class="size-5 shrink-0 transition" aria-hidden="true"
                        x-bind:class="selectedAccordionItem === 'one' ? 'rotate-180' : ''">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
                <div x-cloak x-show="selectedAccordionItem === 'one'" class="bg-[#292a37]" id="accordionItemOne"
                    role="region" aria-labelledby="controlsAccordionItemOne" x-collapse>
                    <div class="p-4 text-sm text-pretty">
                        Nxcai is an automated Ai trading bot that helps you trade the forex and crypto
                        market easily with a proven scalping strategy powered by a strong algorithm that
                        trades the market, opens and closes trades within seconds targeting profits per
                        trade which in end accumulates profits gradually. All you need to do is create
                        an account, start a trade on demo to see how it works, then fund your account to
                        make real profits.
                    </div>
                </div>
            </div>

            <div>
                <button id="controlsAccordionItemTwo" type="button"
                    class="flex w-full items-center justify-between gap-4 bg-[#1e1f2a] p-4 text-left underline-offset-2 hover:bg-neutral-50/75 focus-visible:bg-neutral-50/75 focus-visible:underline focus-visible:outline-hidden dark:bg-neutral-900 dark:hover:bg-neutral-900/75 dark:focus-visible:bg-neutral-900/75"
                    aria-controls="accordionItemTwo" x-on:click="selectedAccordionItem = 'two'"
                    x-bind:class="selectedAccordionItem === 'two' ?
                        'text-onSurfaceStrong dark:text-onSurfaceDarkStrong font-bold' :
                        'text-onSurface dark:text-onSurfaceDark font-medium'"
                    x-bind:aria-expanded="selectedAccordionItem === 'two' ? 'true' : 'false'">
                    Do I need trading skills to earn?
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2"
                        stroke="currentColor" class="size-5 shrink-0 transition" aria-hidden="true"
                        x-bind:class="selectedAccordionItem === 'two' ? 'rotate-180' : ''">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
                <div x-cloak x-show="selectedAccordionItem === 'two'" class="bg-[#292A37]" id="accordionItemTwo"
                    role="region" aria-labelledby="controlsAccordionItemTwo" x-collapse>
                    <div class="p-4 text-sm  text-pretty">
                        No, you don't need any trading skills to profit from this, you can earn from
                        Nxcai with zero knowledge in trading. The Ai bot handles all the trades for you
                        and make profits, all you need to do is start the robot.
                    </div>
                </div>
            </div>

            <div>
                <button id="controlsAccordionItemThree" type="button"
                    class="flex w-full items-center justify-between gap-4 bg-[#1e1f2a] p-4 text-left underline-offset-2 hover:bg-neutral-50/75 focus-visible:bg-neutral-50/75 focus-visible:underline focus-visible:outline-hidden dark:bg-neutral-900 dark:hover:bg-neutral-900/75 dark:focus-visible:bg-neutral-900/75"
                    aria-controls="accordionItemThree" x-on:click="selectedAccordionItem = 'three'"
                    x-bind:class="selectedAccordionItem === 'three' ?
                        'text-onSurfaceStrong dark:text-onSurfaceDarkStrong font-bold' :
                        'text-onSurface dark:text-onSurfaceDark font-medium'"
                    x-bind:aria-expanded="selectedAccordionItem === 'three' ? 'true' : 'false'">
                    Are there any fees?
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2"
                        stroke="currentColor" class="size-5 shrink-0 transition" aria-hidden="true"
                        x-bind:class="selectedAccordionItem === 'three' ? 'rotate-180' : ''">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
                <div x-cloak x-show="selectedAccordionItem === 'three'" class="bg-[#292A37]" id="accordionItemThree"
                    role="region" aria-labelledby="controlsAccordionItemThree" x-collapse>
                    <div class="p-4 text-sm  text-pretty">
                        Yes, there's a 1% fee charged from profits made by the bot. For example, when
                        you trade and the AI makes $100 in profits, the company charges you 1% of the
                        $100 profits made by the bot, not from your capital but only from the profits
                        made.
                    </div>
                </div>
            </div>

            <div>
                <button id="controlsAccordionItemFour" type="button"
                    class="flex w-full items-center justify-between gap-4 bg-[#1e1f2a] p-4 text-left underline-offset-2 hover:bg-neutral-50/75 focus-visible:bg-neutral-50/75 focus-visible:underline focus-visible:outline-hidden dark:bg-neutral-900 dark:hover:bg-neutral-900/75 dark:focus-visible:bg-neutral-900/75"
                    aria-controls="accordionItemFour" x-on:click="selectedAccordionItem = 'four'"
                    x-bind:class="selectedAccordionItem === 'four' ?
                        'text-onSurfaceStrong dark:text-onSurfaceDarkStrong font-bold' :
                        'text-onSurface dark:text-onSurfaceDark font-medium'"
                    x-bind:aria-expanded="selectedAccordionItem === 'four' ? 'true' : 'false'">
                    Is my funds safe?
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2"
                        stroke="currentColor" class="size-5 shrink-0 transition" aria-hidden="true"
                        x-bind:class="selectedAccordionItem === 'four' ? 'rotate-180' : ''">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
                <div x-cloak x-show="selectedAccordionItem === 'four'" class="bg-[#292A37]" id="accordionItemFour"
                    role="region" aria-labelledby="controlsAccordionItemFour" x-collapse>
                    <div class="p-4 text-sm  text-pretty">
                        Yes! Your funds and capital is 100% safe and secured on the system, you don't
                        have to be scared of loosing out, your capital is returned after every trade.
                        You can choose to withdraw both your capital and profits anytime.100% guarantee
                        on withdrawals.
                    </div>
                </div>
            </div>

            <div>
                <button id="controlsAccordionItemFive" type="button"
                    class="flex w-full items-center justify-between gap-4 bg-[#1e1f2a] p-4 text-left underline-offset-2 hover:bg-neutral-50/75 focus-visible:bg-neutral-50/75 focus-visible:underline focus-visible:outline-hidden dark:bg-neutral-900 dark:hover:bg-neutral-900/75 dark:focus-visible:bg-neutral-900/75"
                    aria-controls="accordionItemFive" x-on:click="selectedAccordionItem = 'five'"
                    x-bind:class="selectedAccordionItem === 'five' ?
                        'text-onSurfaceStrong dark:text-onSurfaceDarkStrong font-bold' :
                        'text-onSurface dark:text-onSurfaceDark font-medium'"
                    x-bind:aria-expanded="selectedAccordionItem === 'five' ? 'true' : 'false'">
                    How fast is Deposit and Withdrawal?
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2"
                        stroke="currentColor" class="size-5 shrink-0 transition" aria-hidden="true"
                        x-bind:class="selectedAccordionItem === 'five' ? 'rotate-180' : ''">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
                <div x-cloak x-show="selectedAccordionItem === 'five'" class="bg-[#292A37]" id="accordionItemFive"
                    role="region" aria-labelledby="controlsAccordionItemFive" x-collapse>
                    <div class="p-4 text-sm  text-pretty">
                        Deposits and Withdrawals are instantly processed and should arrive within 30
                        minutes maximum. There are no fees on deposits and withdrawals. Deposits and
                        withdrawals are processed through crypto.
                    </div>
                </div>
            </div>

            <div>
                <button id="controlsAccordionItemSix" type="button"
                    class="flex w-full items-center justify-between gap-4 bg-[#1e1f2a] p-4 text-left underline-offset-2 hover:bg-neutral-50/75 focus-visible:bg-neutral-50/75 focus-visible:underline focus-visible:outline-hidden dark:bg-neutral-900 dark:hover:bg-neutral-900/75 dark:focus-visible:bg-neutral-900/75"
                    aria-controls="accordionItemSix" x-on:click="selectedAccordionItem = 'six'"
                    x-bind:class="selectedAccordionItem === 'six' ?
                        'text-onSurfaceStrong dark:text-onSurfaceDarkStrong font-bold' :
                        'text-onSurface dark:text-onSurfaceDark font-medium'"
                    x-bind:aria-expanded="selectedAccordionItem === 'six' ? 'true' : 'false'">
                    Does Nxcai Increase my returns daily?
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2"
                        stroke="currentColor" class="size-5 shrink-0 transition" aria-hidden="true"
                        x-bind:class="selectedAccordionItem === 'six' ? 'rotate-180' : ''">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
                <div x-cloak x-show="selectedAccordionItem === 'six'" class="bg-[#292A37]" id="accordionItemSix"
                    role="region" aria-labelledby="controlsAccordionItemSix" x-collapse>
                    <div class="p-4 text-sm  text-pretty">
                        Yes, it does. Our AI Bot increases customer assets daily and tries to eliminate
                        the potential for liquidation risk. By combining AI with a proven scalping
                        trading strategy, we created an AI Bot that trades autonomously, buying low and
                        selling high at the right time, while constantly modifying positions to
                        potentially increase steady returns and cut down risk.
                    </div>
                </div>
            </div>

            <div>
                <button id="controlsAccordionItemSeven" type="button"
                    class="flex w-full items-center justify-between gap-4 bg-[#1e1f2a] p-4 text-left underline-offset-2 hover:bg-neutral-50/75 focus-visible:bg-neutral-50/75 focus-visible:underline focus-visible:outline-hidden dark:bg-neutral-900 dark:hover:bg-neutral-900/75 dark:focus-visible:bg-neutral-900/75"
                    aria-controls="accordionItemSeven" x-on:click="selectedAccordionItem = 'seven'"
                    x-bind:class="selectedAccordionItem === 'seven' ?
                        'text-onSurfaceStrong dark:text-onSurfaceDarkStrong font-bold' :
                        'text-onSurface dark:text-onSurfaceDark font-medium'"
                    x-bind:aria-expanded="selectedAccordionItem === 'seven' ? 'true' : 'false'">
                    What is the minimum deposit and withdrawal?
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2"
                        stroke="currentColor" class="size-5 shrink-0 transition" aria-hidden="true"
                        x-bind:class="selectedAccordionItem === 'seven' ? 'rotate-180' : ''">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
                <div x-cloak x-show="selectedAccordionItem === 'seven'" class="bg-[#292A37]" id="accordionItemSeven"
                    role="region" aria-labelledby="controlsAccordionItemSeven" x-collapse>
                    <div class="p-4 text-sm  text-pretty">
                        The minimum deposit is $100, the minimum withdrawal is $10. There are no limits
                        on deposits and withdrawals, you can choose to deposit and withdraw any amounts
                        as the forex and crypto market is unlimited. Deposits and withdrawals are
                        processed through cryptocurrency.
                    </div>
                </div>
            </div>

            <div>
                <button id="controlsAccordionItemEight" type="button"
                    class="flex w-full items-center justify-between gap-4 bg-[#1e1f2a] p-4 text-left underline-offset-2 hover:bg-neutral-50/75 focus-visible:bg-neutral-50/75 focus-visible:underline focus-visible:outline-hidden dark:bg-neutral-900 dark:hover:bg-neutral-900/75 dark:focus-visible:bg-neutral-900/75"
                    aria-controls="accordionItemEight" x-on:click="selectedAccordionItem = 'eight'"
                    x-bind:class="selectedAccordionItem === 'eight' ?
                        'text-onSurfaceStrong dark:text-onSurfaceDarkStrong font-bold' :
                        'text-onSurface dark:text-onSurfaceDark font-medium'"
                    x-bind:aria-expanded="selectedAccordionItem === 'eight' ? 'true' : 'false'">
                    What else do I need to know?
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2"
                        stroke="currentColor" class="size-5 shrink-0 transition" aria-hidden="true"
                        x-bind:class="selectedAccordionItem === 'eight' ? 'rotate-180' : ''">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
                <div x-cloak x-show="selectedAccordionItem === 'eight'" class="bg-[#292A37]" id="accordionItemEight"
                    role="region" aria-labelledby="controlsAccordionItemEight" x-collapse>
                    <div class="p-4 text-sm  text-pretty">
                        Getting started with Nxcai is very easy, you don't need any technical knowledge
                        to earn from this. there are 4 strategies you can choose from each of them has a
                        certain minimum amount and a certain profit percentage, you will have to choose
                        the strategy that matches your trade amount. This works for every country, the
                        robot trades on both weekdays and weekends, trades forex and crypto during the
                        week and trades only crypto during weekends. You can always contact our live
                        support if you need further help.
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
