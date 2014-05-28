#!/bin/bash

echo "Building fr-FR.mo ..."
if msgfmt -o guestapp-fr_FR.mo fr_FR.po; then
	echo -e "\e[34mSuccess\e[0m"
else
	echo -e "\e[31mError\e[0m"
fi

echo "Building en-EN.mo ..."
if msgfmt -o guestapp-en_EN.mo en_EN.po; then
	echo -e "\e[34mSuccess\e[0m"
else
	echo -e "\e[31mError\e[0m"
fi
if msgfmt -o guestapp-en_GB.mo en_EN.po; then
	echo -e "\e[34mSuccess\e[0m"
else
	echo -e "\e[31mError\e[0m"
fi
if msgfmt -o guestapp-en_US.mo en_EN.po; then
	echo -e "\e[34mSuccess\e[0m"
else
	echo -e "\e[31mError\e[0m"
fi

echo "Building de-DE.mo ..."
if msgfmt -o guestapp-de_DE.mo de_DE.po; then
	echo -e "\e[34mSuccess\e[0m"
else
	echo -e "\e[31mError\e[0m"
fi

echo "Building nl-NL.mo ..."
if msgfmt -o guestapp-nl_NL.mo nl_NL.po; then
	echo -e "\e[34mSuccess\e[0m"
else
	echo -e "\e[31mError\e[0m"
fi

echo "Building es-ES.mo ..."
if msgfmt -o guestapp-es_ES.mo es_ES.po; then
	echo -e "\e[34mSuccess\e[0m"
else
	echo -e "\e[31mError\e[0m"
fi

echo "Done."