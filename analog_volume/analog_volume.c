#include <wiringPi.h>

#include <stdio.h>
#include <stdlib.h>
#include <stdint.h>

int pin_a = 23;
int pin_b = 24;
int lastEncoded = 0;
long value = 0;

void gpiocb() {
        int MSB = digitalRead(pin_a);
        int LSB = digitalRead(pin_b);

        int encoded = (MSB << 1) | LSB;
        int sum = (lastEncoded << 2) | encoded;

        if(sum == 0b1101 || sum == 0b0100 || sum == 0b0010 || sum == 0b1011) value++;
        if(sum == 0b1110 || sum == 0b0111 || sum == 0b0001 || sum == 0b1000) value--;

	lastEncoded = encoded;
	printf("MSB : %i, LSB : %i, encoded : %i, sum : %i, value : %li\n", MSB, LSB, encoded, sum, value);
}

int main() {
   // printf() displays the string inside quotation
   wiringPiSetupGpio();
    pinMode(pin_a, INPUT);
    pinMode(pin_b, INPUT);
    pullUpDnControl(pin_a, PUD_UP);
    pullUpDnControl(pin_b, PUD_UP);
    wiringPiISR(pin_a,INT_EDGE_BOTH, gpiocb);
    wiringPiISR(pin_b,INT_EDGE_BOTH, gpiocb);

    while(1) {
	delay(100);
	//printf("%i", lastEncoded);
    }

}